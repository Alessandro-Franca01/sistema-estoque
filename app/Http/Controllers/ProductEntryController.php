<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductEntryRequest;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductEntry::with(['product', 'supplier']);

        // Search
        if ($request->has('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            })->orWhereHas('supplier', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->search . '%');
            })->orWhere('invoice_number', 'like', '%' . $request->search . '%');
        }

        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by supplier
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('entry_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('entry_date', '<=', $request->end_date);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'entry_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $entries = $query->paginate(15);
        $products = Product::active()->get();
        $suppliers = Supplier::active()->get();

        return view('product_entries.index', compact('entries', 'products', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $products = Product::active()->get();
        $suppliers = Supplier::active()->get();
        $selectedProductId = $request->input('product_id');
        
        return view('product_entries.create', compact('products', 'suppliers', 'selectedProductId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductEntryRequest $request)
    {
        $data = $request->validated();
        
        // Calcular o custo total se não for fornecido
        if (empty($data['total_cost']) && !empty($data['unit_cost']) && !empty($data['quantity'])) {
            $data['total_cost'] = $data['unit_cost'] * $data['quantity'];
        }
        
        $entry = ProductEntry::create($data);

        return redirect()->route('product_entries.index')
            ->with('success', 'Entrada de produto registrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductEntry $productEntry)
    {
        $productEntry->load(['product', 'supplier']);
        return view('product_entries.show', compact('productEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductEntry $productEntry)
    {
        $products = Product::active()->get();
        $suppliers = Supplier::active()->get();
        return view('product_entries.edit', compact('productEntry', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductEntryRequest $request, ProductEntry $productEntry)
    {
        // Armazenar a quantidade antiga para ajustar o estoque
        $oldQuantity = $productEntry->quantity;
        
        $data = $request->validated();
        
        // Calcular o custo total se não for fornecido
        if (empty($data['total_cost']) && !empty($data['unit_cost']) && !empty($data['quantity'])) {
            $data['total_cost'] = $data['unit_cost'] * $data['quantity'];
        }
        
        $productEntry->update($data);
        
        // Ajustar o estoque do produto
        $product = $productEntry->product;
        $product->stock_quantity = $product->stock_quantity - $oldQuantity + $productEntry->quantity;
        $product->save();

        return redirect()->route('product_entries.index')
            ->with('success', 'Entrada de produto atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductEntry $productEntry)
    {
        // Ajustar o estoque do produto antes de excluir a entrada
        $product = $productEntry->product;
        $product->stock_quantity -= $productEntry->quantity;
        $product->save();
        
        $productEntry->delete();

        return redirect()->route('product_entries.index')
            ->with('success', 'Entrada de produto excluída com sucesso.');
    }
}
