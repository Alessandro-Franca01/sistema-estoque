<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = \App\Models\Inventory::all();
        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $inventory = new \App\Models\Inventory([
            'start_date' => $request->get('start_date'),
            'user_id' => auth()->id(),
        ]);
        $inventory->save();

        return redirect()->route('inventories.index')->with('success', 'Inventário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = \App\Models\Inventory::with('items.product')->findOrFail($id);
        return view('inventories.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = \App\Models\Inventory::findOrFail($id);
        $products = \App\Models\Product::all();
        return view('inventories.edit', compact('inventory', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:OPEN,IN_PROGRESS,CLOSED',
            'end_date' => 'nullable|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.real_amount' => 'nullable|numeric',
            'items.*.observations' => 'nullable|string',
        ]);

        $inventory = \App\Models\Inventory::findOrFail($id);
        $inventory->update($request->only(['status', 'end_date']));

        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $inventory->items()->updateOrCreate(
                    ['product_id' => $itemData['product_id']],
                    $itemData
                );
            }
        }

        return redirect()->route('inventories.index')->with('success', 'Inventário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = \App\Models\Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventário excluído com sucesso.');
    }
}
