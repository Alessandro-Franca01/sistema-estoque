<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Helpers\AuditHelper;

class ProductController extends Controller
{
    public function __construct()
    {
        // Aplica as autorizações baseadas na ProductPolicy automaticamente
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category']);

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
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // TODO: FAZER TESTE USANDO A MEDIDA CUSTOMIZADA
        if ($request->has('custom_meansurement_unit') && !empty($request->custom_meansurement_unit)) {
            $data['meansurement_unit'] = $request->custom_meansurement_unit;
        }

        $data['quantity'] = 0;
        $product = Product::create($data);

        // Registra a criação
        if (class_exists(AuditHelper::class)) {
            AuditHelper::logCreate($product, $request);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $oldProduct = $product;

        if ($request->has('custom_meansurement_unit') && !empty($request->custom_meansurement_unit)) {
            $data['meansurement_unit'] = $request->custom_meansurement_unit;
            //unset($data['meansurement_unit_id']); // Remove meansurement_unit_id if custom unit is used
        }

        $product->update($data);

        // Registrar auditoria de atualização
        if (class_exists(AuditHelper::class)) {
            AuditHelper::logUpdate($oldProduct, $product->toArray(), $request);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Exclusão de produtos não é permitida
        return redirect()->route('products.index')
            ->withErrors('Exclusão de produtos não é permitida.');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $oldProduct = $product;
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'ativado' : 'desativado';

        // Registrar auditoria de alteração de status:
        // TODO Erro na passagem do audit_id como null
        if (class_exists(AuditHelper::class)) {
            request() ? AuditHelper::logUpdate($oldProduct, $product->toArray(), request()) : null;
        }

        return redirect()->back()
            ->with('success', "Produto {$status} com sucesso.");
    }
}
