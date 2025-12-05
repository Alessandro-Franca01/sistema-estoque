<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::latest()->paginate(10);

        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sigla' => 'required|string|max:10',
            'description' => 'nullable|string',
            'cep' => 'required|string|max:9',
            'address' => 'required|string|max:255',
            'address_number' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        // Handle checkbox: if not present in request, set to false 1628336465
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        dd($validated);
        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departamento criado com sucesso!');
    }

    public function show(Department $department): View
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sigla' => 'required|string|max:10',
            'description' => 'nullable|string',
            'cep' => 'required|string|max:9',
            'address' => 'required|string|max:255',
            'address_number' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        // Handle checkbox: if not present in request, set to false
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy(Department $department): RedirectResponse
    {
        // Check for related records before deletion
        $relatedRecords = [];

        if ($department->categories()->count() > 0) {
            $relatedRecords[] = 'categorias';
        }
        if ($department->products()->count() > 0) {
            $relatedRecords[] = 'produtos';
        }
        if ($department->suppliers()->count() > 0) {
            $relatedRecords[] = 'fornecedores';
        }
        if ($department->entries()->count() > 0) {
            $relatedRecords[] = 'entradas';
        }
        if ($department->outputs()->count() > 0) {
            $relatedRecords[] = 'saídas';
        }
        if ($department->calls()->count() > 0) {
            $relatedRecords[] = 'chamados';
        }
        if ($department->inventories()->count() > 0) {
            $relatedRecords[] = 'inventários';
        }
        if ($department->publicServants()->count() > 0) {
            $relatedRecords[] = 'servidores públicos';
        }

        if (!empty($relatedRecords)) {
            $message = 'Não é possível excluir este departamento pois existem registros relacionados: '
                . implode(', ', $relatedRecords) . '.';

            return redirect()->route('departments.index')
                ->with('error', $message);
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departamento excluído com sucesso!');
    }
}
