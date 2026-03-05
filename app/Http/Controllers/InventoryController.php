<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ItemInventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::with('items.product');

        // Filtros
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && !empty($request->date)) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('start_date', today());
                    break;
                case 'week':
                    $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('start_date', now()->month);
                    break;
            }
        }

        // Ordenação
        if ($request->has('sort') && $request->sort == 'id') {
            $direction = $request->get('direction', 'asc');
            $query->orderBy('id', $direction);
        } else {
            $query->latest();
        }

        $inventories = $query->paginate(15);

        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
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
            'observations' => 'nullable|string',
        ]);

        DB::transaction(function() use ($request) {
            $inventory = Inventory::create([
                'start_date' => $request->start_date,
                'user_id' => auth()->id(),
                'observations' => $request->observations,
                'status' => 'OPEN',
            ]);

            if ($request->has('products')) {
                foreach ($request->products as $productId) {
                    $product = Product::find($productId);
                    if ($product) {
                        ItemInventory::create([
                            'inventory_id' => $inventory->id,
                            'product_id' => $product->id,
                            'register_amount' => $product->quantity,
                            'real_amount' => null,
                            'reason' => null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('inventories.index')
            ->with('success', 'Inventário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = Inventory::with(['items.product', 'user'])
            ->findOrFail($id);

        // Estatísticas para o dashboard
        $stats = [
            'total_items' => $inventory->items->count(),
            'counted_items' => $inventory->items->whereNotNull('real_amount')->count(),
            'divergent_items' => $inventory->items->filter(function($item) {
                return $item->real_amount !== null &&
                    $item->real_amount != $item->register_amount;
            })->count(),
            'progress' => $inventory->items->count() > 0
                ? round(($inventory->items->whereNotNull('real_amount')->count() / $inventory->items->count()) * 100)
                : 0,
        ];

        return view('inventories.show', compact('inventory', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::with('items.product')->findOrFail($id);

        // Se já estiver fechado, redireciona para visualização
        if ($inventory->status === 'CLOSED') {
            return redirect()->route('inventories.show', $id)
                ->with('info', 'Este inventário já está fechado e não pode ser editado.');
        }

        $products = Product::all();

        // Estatísticas para o dashboard
        $stats = [
            'total_items' => $inventory->items->count(),
            'counted_items' => $inventory->items->whereNotNull('real_amount')->count(),
            'divergent_items' => $inventory->items->filter(function($item) {
                return $item->real_amount !== null &&
                    $item->real_amount != $item->register_amount;
            })->count(),
            'progress' => $inventory->items->count() > 0
                ? round(($inventory->items->whereNotNull('real_amount')->count() / $inventory->items->count()) * 100)
                : 0,
        ];

        return view('inventories.edit', compact('inventory', 'products', 'stats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:OPEN,STOPPED,CLOSED',
            'end_date' => 'nullable|date',
            'observations' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($id);

        // Se já estiver fechado, não permite atualização
        if ($inventory->status === 'CLOSED' && $request->status !== 'CLOSED') {
            return back()->with('error', 'Inventário fechado não pode ser reaberto.');
        }

        DB::transaction(function() use ($request, $inventory) {
            $updateData = $request->only(['status', 'observations']);

            // Se estiver fechando, define a data de fim
            if ($request->status === 'CLOSED' && $inventory->status !== 'CLOSED') {
                $updateData['end_date'] = $request->end_date ?? now();
            }

            // Se estiver reabrindo, limpa a data de fim
            if ($request->status !== 'CLOSED' && $inventory->status === 'CLOSED') {
                $updateData['end_date'] = null;
            }

            $inventory->update($updateData);

            // Se estiver fechando, atualiza os estoques
            if ($request->status === 'CLOSED' && $inventory->status !== 'CLOSED') {
                foreach ($inventory->items as $item) {
                    if (!is_null($item->real_amount)) {
                        $product = $item->product;
                        $product->quantity = $item->real_amount;
                        $product->save();
                    }
                }
            }
        });

        $message = $request->status === 'CLOSED'
            ? 'Inventário finalizado com sucesso.'
            : 'Inventário atualizado com sucesso.';

        return redirect()->route('inventories.show', $id)
            ->with('success', $message);
    }

    /**
     * Update inventory items (used for saving progress and final counting)
     */
    public function updateItems(Request $request, string $id)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.real_amount' => 'nullable|numeric|min:0',
            'items.*.reason' => 'nullable|string|max:255',
        ]);

        $inventory = Inventory::findOrFail($id);

        // Verifica se o inventário está aberto
        if ($inventory->status === 'CLOSED') {
            return response()->json([
                'success' => false,
                'message' => 'Inventário já está fechado.'
            ], 403);
        }

        DB::transaction(function() use ($request, $inventory) {
            $errorMessages = [];

            foreach ($request->items as $index => $itemData) {
                $item = $inventory->items()
                    ->where('product_id', $itemData['product_id'])
                    ->first();

                if ($item) {
                    $updateData = [];

                    // Atualiza quantidade real se fornecida
                    if (array_key_exists('real_amount', $itemData)) {
                        $updateData['real_amount'] = $itemData['real_amount'] !== ''
                            ? $itemData['real_amount']
                            : null;
                    }

                    // Atualiza observações se fornecidas
                    if (array_key_exists('reason', $itemData)) {
                        $updateData['reason'] = $itemData['reason'];
                    }

                    // Calcula diferença se houver quantidade real
                    if (isset($updateData['real_amount'])) {
                        $difference = $updateData['real_amount'] - $item->register_amount;

                        // Valida se há observação para diferenças
                        if ($difference != 0 && empty($updateData['reason'])) {
                            $errorMessages["items.$index.reason"] =
                                'Informe o MOTIVO quando houver diferença na contagem.';
                        }
                    }
                    $item->update($updateData);
                }
            }

            // Se houver erros, retorna com mensagens
            if (!empty($errorMessages)) {
                return back()->withErrors($errorMessages)->withInput();
            }
        });

        // Verifica se é uma requisição AJAX (salvar progresso)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Progresso salvo com sucesso!',
                'stats' => $this->getInventoryStats($inventory)
            ]);
        }

        return redirect()->route('inventories.show', $id)
            ->with('success', 'Itens do inventário atualizados com sucesso.');
    }

    /**
     * Save progress via AJAX
     */
    public function saveProgress(Request $request, string $id)
    {
        return $this->updateItems($request, $id);
    }

    /**
     * Add a new item to inventory
     */
    public function addItem(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $inventory = Inventory::findOrFail($id);

        // Verifica se o produto já está no inventário
        $existingItem = $inventory->items()
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingItem) {
            return response()->json([
                'success' => false,
                'message' => 'Este produto já está no inventário.'
            ], 422);
        }

        $product = Product::find($request->product_id);

        $item = ItemInventory::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'register_amount' => $product->quantity,
            'real_amount' => null,
            'reason' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produto adicionado ao inventário.',
            'item' => $item->load('product')
        ]);
    }

    /**
     * Remove an item from inventory
     */
    public function removeItem(Request $request, string $id, string $itemId)
    {
        $inventory = Inventory::findOrFail($id);

        if ($inventory->status === 'CLOSED') {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível remover itens de um inventário fechado.'
            ], 403);
        }

        $item = ItemInventory::where('inventory_id', $id)
            ->where('id', $itemId)
            ->firstOrFail();

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removido do inventário.'
        ]);
    }

    /**
     * Get inventory statistics
     */
    private function getInventoryStats(Inventory $inventory)
    {
        $totalItems = $inventory->items->count();
        $countedItems = $inventory->items->whereNotNull('real_amount')->count();
        $divergentItems = $inventory->items->filter(function($item) {
            return $item->real_amount !== null &&
                $item->real_amount != $item->register_amount;
        })->count();

        return [
            'total_items' => $totalItems,
            'counted_items' => $countedItems,
            'divergent_items' => $divergentItems,
            'progress' => $totalItems > 0
                ? round(($countedItems / $totalItems) * 100)
                : 0,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);

        // Verifica se pode excluir
        if ($inventory->status === 'CLOSED') {
            return back()->with('error', 'Não é possível excluir um inventário fechado.');
        }

        DB::transaction(function() use ($inventory) {
            // Remove os itens primeiro
            $inventory->items()->delete();
            // Remove o inventário
            $inventory->delete();
        });

        return redirect()->route('inventories.index')
            ->with('success', 'Inventário excluído com sucesso.');
    }

    /**
     * Generate inventory report
     */
    public function report(string $id)
    {
        $inventory = Inventory::with(['items.product', 'user'])
            ->findOrFail($id);

        $stats = $this->getInventoryStats($inventory);

        $divergences = $inventory->items
            ->filter(function($item) {
                return $item->real_amount !== null &&
                    $item->real_amount != $item->register_amount;
            })
            ->map(function($item) {
                return [
                    'product' => $item->product->name,
                    'register_amount' => $item->register_amount,
                    'real_amount' => $item->real_amount,
                    'difference' => $item->real_amount - $item->register_amount,
                    'reason' => $item->reason,
                ];
            });

        return view('inventories.report', compact('inventory', 'stats', 'divergences'));
    }
}
