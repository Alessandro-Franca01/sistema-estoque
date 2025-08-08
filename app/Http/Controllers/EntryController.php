<?php

namespace App\Http\Controllers;

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
        dd($request->all());
        $entry = Entry::create($request->validated());

        foreach ($request->products as $productData) {
            $entry->products()->attach($productData['product_id'], [
                'entry_id' => $entry->id,
                'batch_item' => $productData['batch_number'],
                'quantity' => $productData['quantity'],
                'unit_cost' => $productData['unit_cost'],
                'total_cost' => $productData['quantity'] * $productData['unit_cost'], // TODO: MELHORAR ISSO!
            ]);

            // TODO: TESTAR ESSE TRECHO DE CÓDIGO! NAO FUNCIONADO
            $product = Product::find($productData['product_id']);
            if ($product) {
                $product->increment('quantity', $productData['quantity']);
            }
        }

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

        $entry->update($request->validated());

        $productData = [];
        foreach ($request->products as $product) {
            $productData[$product['product_id']] = [
                'batch_number' => $product['batch_number'],
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'],
                'total_cost' => $product['quantity'] * $product['unit_cost'],
            ];

            $productId = $product['product_id'];
            $newQuantity = $product['quantity'];
            $oldQuantity = $originalProductQuantities[$productId] ?? 0;

            $productModel = Product::find($productId);
            if ($productModel) {
                $difference = $newQuantity - $oldQuantity;
                $productModel->increment('quantity', $difference);
            }
        }

        // Handle products that were removed from the entry
        $removedProductIds = array_diff(array_keys($originalProductQuantities), array_keys($productData));
        foreach ($removedProductIds as $productId) {
            $productModel = Product::find($productId);
            if ($productModel) {
                $productModel->decrement('quantity', $originalProductQuantities[$productId]);
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
        foreach ($entry->products as $product) {
            $productModel = Product::find($product->id);
            if ($productModel) {
                $productModel->decrement('quantity', $product->pivot->quantity);
            }
        }

        $entry->delete();
        return redirect()->route('entries.index')->with('success', 'Entrada excluída com sucesso!');
    }
}
