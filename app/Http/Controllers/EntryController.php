<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Http\Requests\Entry\StoreEntryFeedingRequest;
use App\Models\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Http\Requests\EntryStoreRequest;
use App\Http\Requests\EntryUpdateRequest;
use Illuminate\Support\Facades\DB;

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
        $entries = Entry::with(['supplier', 'products'])->latest()->paginate(6);

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

        // TODO REMOVER ESSE COMENTARIO DEPOIS QUE RESETAR O BANCO E TESTAR
        if ($request->has('entry_type') != Entry::TYPE_PURCHASED) {
            throw new \Exception('Tipo de entrada inválido.');
        }
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

    public function createReversal()
    {
        $entries = Entry::where('entry_type', '=', 'purchased')->get();

        return view('entries.reversal', compact('entries'));
    }

    public function storeReversal(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'entry' => 'required',
            'observation' => 'required|string|max:3000',
        ]);

        DB::transaction(function () use ($request) {
            $entryToReverse = Entry::findOrFail($request->entry);

            // Prevenir duplo estorno
            if ($entryToReverse->entry_type === Entry::TYPE_REVERSAL) {
                throw new \Exception('Esta entrada já foi estornada.');
            }

            // Subtrair produtos do estoque
            foreach ($entryToReverse->products as $product) {
                $productModel = Product::find($product->id);
                if ($productModel) {
                    $productModel->decrement('quantity', $product->pivot->quantity);
                }
            }

            // Marcar a entrada como estornada e salvar o motivo
            $entryToReverse->update([
                'entry_type' => Entry::TYPE_REVERSAL,
                'observation' => $entryToReverse->observation,
            ]);

            // TODO: NAO ESTA SALVVANDO OS VALORES ANTIGOS
            AuditHelper::logUpdate($entryToReverse, ['entry_type', 'observation'], $request);
        });

        return redirect()->route('entries.index')->with('success', 'Entrada estornada com sucesso!');
    }

    public function createFeeding()
    {
        $suppliers = Supplier::all();
        $products = Product::WHERE('quantity', '=', 0)->get();

        return view('entries.feeding', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created feeding type entry in storage.
     *
     * @param  \App\Http\Requests\EntryStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFeeding(StoreEntryFeedingRequest $request)
    {
//        dd($request->all());
        if ($request->has('entry_type') != Entry::TYPE_FEEDING) {
            throw new \Exception('Tipo de entrada inválido.');
        }
        $data = $request->validated();

        // Impedir alimentação duplicada para o mesmo produto
        // 1) Normaliza a lista de produtos do request
        $requestedProductIds = collect($request->products ?? [])
            ->pluck('product_id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->values();
//        dd('step 1', $requestedProductIds);
        // 2) Verifica duplicados dentro do próprio request TODO: (Add validation for duplicates at view form)
        $duplicatesInRequest = $requestedProductIds->duplicates()->unique()->values();
//        dd('step 1', $duplicatesInRequest);
        if ($duplicatesInRequest->isNotEmpty()) {
            $duplicateProducts = Product::whereIn('id', $duplicatesInRequest)->pluck('name')->toArray();
            return back()
                ->withErrors(['products' => 'Há produtos repetidos na lista: ' . implode(', ', $duplicateProducts)])
                ->withInput();
        }
        // 3) Add vallidation to check if the product not have any item in stock
        $products = Product::Query()->whereNotIn('id', $requestedProductIds)->where('quantity', '>', 0)->get();
//        dd($products);
        $entry = DB::transaction(function () use ($data, $request) {
            $entry = Entry::create($data);

            foreach ($request->products as $productData) {
                $productData['unit_cost'] = empty($productData['unit_cost']) ? 0 : $productData['unit_cost'];
                $productData['quantity'] = empty($productData['quantity']) ? 0 : $productData['quantity'];

                $entry->products()->attach($productData['product_id'], [
                    'entry_id' => $entry->id,
                    'batch_item' => $productData['batch_item'] ?? null,
                    'quantity' => $productData['quantity'],
                    'unit_cost' => $productData['unit_cost'],
                    'total_cost' => $productData['quantity'] * $productData['unit_cost'],
                    'created_at' => $entry->created_at,
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
        });

        return redirect()->route('entries.index')->with('success', 'Entrada tipo alimentação criada com sucesso!');
    }
}
