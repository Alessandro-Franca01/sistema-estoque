<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Http\Requests\EntryStoreRequest;
use App\Http\Requests\EntryUpdateRequest;

class EntryController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:entries.read')->only(['index', 'show']);
//        $this->middleware('permission:entries.create')->only(['create', 'store']);
//        $this->middleware('permission:entries.update')->only(['edit', 'update']);
//        $this->middleware('permission:entries.delete')->only('destroy');
//        $this->middleware('permission:entries.approve')->only(['approve', 'reject']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Entry::with(['supplier', 'products'])->latest()->paginate(10);

        return view('entries.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('entries.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntryStoreRequest $request)
    {
        $data = $request->validated();

        // TODO REMOVER ESSA GAMBI DEPOIS que resetar o banco
        $entryType = Entry::TYPE_PURCHASED;
        if ($request->has('entry_type') == 'feeding') {
            $entryType = 'initial_entry';
        }

        $data['entry_type'] = $entryType;
        $entry = Entry::create($data);

        foreach ($request->products as $productData) {
            $entry->products()->attach($productData['product_id'], [
                'entry_id' => $entry->id,
                'batch_item' => $productData['batch_item'] ?? null,
                'quantity' => $productData['quantity'],
                'unit_cost' => $productData['unit_cost'],
                'total_cost' => $productData['quantity'] * $productData['unit_cost'],
            ]);

            $product = Product::find($productData['product_id']);
            if ($product) {
                $product->increment('quantity', $productData['quantity']);
            }
        }
        // Prepare data for audit
        $jsonData = $request->all();
        unset($jsonData['_token']);
        AuditHelper::logCreateCustomData($entry, $request, [], $jsonData);

        return redirect()->route('entries.index')->with('success', 'Entrada criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        $entry->load(['supplier', 'products']);
        return view('entries.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        $entry->load('products');
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('entries.edit', compact('entry', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntryUpdateRequest $request, Entry $entry)
    {
        // Get original product quantities before update
        $originalProductQuantities = $entry->products->pluck('pivot.quantity', 'id')->toArray();

        // Persist entry first, then compute sign based on possibly changed type
        $entry->update($request->validated());
        $sign = in_array($entry->entry_type, [Entry::TYPE_PURCHASED, Entry::TYPE_FEEDING]) ? 1 : -1;

        $productData = [];
        foreach ($request->products as $product) {
            $productData[$product['product_id']] = [
                'batch_item' => $product['batch_item'] ?? null,
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'],
                'total_cost' => $product['quantity'] * $product['unit_cost'],
            ];

            $productId = $product['product_id'];
            $newQuantity = $product['quantity'];
            $oldQuantity = $originalProductQuantities[$productId] ?? 0;

            $productModel = Product::find($productId);
            if ($productModel) {
                $difference = ($newQuantity - $oldQuantity) * $sign;
                if ($difference >= 0) {
                    $productModel->increment('quantity', $difference);
                } else {
                    $productModel->decrement('quantity', abs($difference));
                }
            }
        }

        // Handle products that were removed from the entry
        $removedProductIds = array_diff(array_keys($originalProductQuantities), array_keys($productData));
        foreach ($removedProductIds as $productId) {
            $productModel = Product::find($productId);
            if ($productModel) {
                $delta = -1 * $sign * $originalProductQuantities[$productId];
                if ($delta >= 0) {
                    $productModel->increment('quantity', $delta);
                } else {
                    $productModel->decrement('quantity', abs($delta));
                }
            }
        }

        $entry->products()->sync($productData);

        return redirect()->route('entries.index')->with('success', 'Entrada atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $sign = in_array($entry->entry_type, [Entry::TYPE_PURCHASED, Entry::TYPE_FEEDING]) ? 1 : -1;
        foreach ($entry->products as $product) {
            $productModel = Product::find($product->id);
            if ($productModel) {
                $delta = -1 * $sign * $product->pivot->quantity; // revert effect of this entry on stock
                if ($delta >= 0) {
                    $productModel->increment('quantity', $delta);
                } else {
                    $productModel->decrement('quantity', abs($delta));
                }
            }
        }

        $entry->delete();
        return redirect()->route('entries.index')->with('success', 'Entrada excluída com sucesso!');
    }
}
