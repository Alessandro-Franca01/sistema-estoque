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
        $inventories = \App\Models\Inventory::with('items.product')->get();
        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = \App\Models\Product::all();
        return view('inventories.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $inventory = new \App\Models\Inventory([
            'start_date' => $request->get('start_date'),
            'user_id' => auth()->id(),
        ]);
        $inventory->save();

        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    \App\Models\ItemInventory::create([
                        'inventory_id' => $inventory->id,
                        'product_id' => $product->id,
                        'register_amount' => $product->quantity,
                    ]);
                }
            }
        }

        return redirect()->route('inventories.index')->with('success', 'Inventário criado com sucesso. Todos os produtos foram adicionados.');
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

        if ($inventory->status == 'CLOSED') {
            foreach ($inventory->items as $item) {
                if (!is_null($item->real_amount)) {
                    $product = $item->product;
                    $product->quantity = $item->real_amount;
                    $product->save();
                }
            }
        }

        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $item = $inventory->items()->where('product_id', $itemData['product_id'])->first();
                if ($item) {
                    $itemData['difference'] = ($itemData['real_amount'] ?? $item->real_amount) - $item->register_amount;
                    $item->update($itemData);
                }
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
