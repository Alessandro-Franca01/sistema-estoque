<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::paginate(15);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('create', Supplier::class);

        $data = $request->validated();
        $supplier = Supplier::create($data);

        AuditHelper::logCreate($supplier, $request);

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $this->authorize('update', $supplier);
        $data = $request->validated();

        if (!isset($data['active'])) {
            $data['active'] = 0;
        };

        $oldSupplier = $supplier;
        $supplier->update($data);

        if (class_exists(AuditHelper::class)) {
            AuditHelper::logUpdate($oldSupplier, $supplier->toArray(), $request);
        }

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor excluído com sucesso.');
    }
}
