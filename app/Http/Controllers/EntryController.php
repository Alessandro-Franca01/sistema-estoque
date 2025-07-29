<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
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
        $entry = Entry::create($request->validated());
        dd($entry);
        foreach ($request->products as $productData) {
            $entry->products()->attach($productData['product_id'], [
                'batch_number' => $productData['batch_number'],
                'quantity' => $productData['quantity'],
                'unit_cost' => $productData['unit_cost'],
                'total_cost' => $productData['quantity'] * $productData['unit_cost'],
            ]);
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
        $entry->update($request->validated());

        $productData = [];
        foreach ($request->products as $product) {
            $productData[$product['product_id']] = [
                'batch_number' => $product['batch_number'],
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'],
                'total_cost' => $product['quantity'] * $product['unit_cost'],
            ];
        }
        $entry->products()->sync($productData);

        return redirect()->route('entries.index')->with('success', 'Entrada atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return redirect()->route('entries.index')->with('success', 'Entrada excluída com sucesso!');
    }
}
