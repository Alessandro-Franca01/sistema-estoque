<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\MeasurementType;
use App\Models\ProductEntry;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'measurementType']);

        // Search
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by measurement type
        if ($request->has('measurement_type_id') && $request->measurement_type_id) {
            $query->where('measurement_types_id', $request->measurement_type_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(15);
        $categories = Category::active()->get();
        $measurementTypes = MeasurementType::active()->get();

        return view('products.index', compact('products', 'categories', 'measurementTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $measurementTypes = MeasurementType::active()->get();
        return view('products.create', compact('categories', 'measurementTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'measurementType');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $measurementTypes = MeasurementType::active()->get();
        return view('products.edit', compact('product', 'categories', 'measurementTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto excluído com sucesso.');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'ativado' : 'desativado';

        return redirect()->back()
            ->with('success', "Produto {$status} com sucesso.");
    }

    /**
     * Update stock quantity.
     */
    // public function updateStock(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'stock_quantity' => 'required|integer|min:0',
    //     ]);

    //     $product->update(['stock_quantity' => $request->stock_quantity]);

    //     return redirect()->back()
    //         ->with('success', 'Estoque atualizado com sucesso.');
    // }

    /**
     * Display the product entries history.
     */
    public function entries(Request $request, Product $product)
    {
        $query = ProductEntry::with(['supplier']) // Keep supplier as ProductEntry has supplier_id
            ->where('product_id', $product->id);

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

        // Order by date (newest first)
        $query->orderBy('created_at', 'desc'); // Changed to created_at as entry_date is not always present

        $productEntries = $query->paginate(15);
        $suppliers = Supplier::active()->get(); // Still needed for filtering entries

        // Calculate totals
        $totalQuantity = $productEntries->sum('quantity');
        $totalCost = $productEntries->sum('total_cost');

        return view('products.entries', compact(
            'product', 
            'productEntries', 
            'suppliers', 
            'totalQuantity', 
            'totalCost'
        ));
    }
}