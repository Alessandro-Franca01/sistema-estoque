<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\PublicServant;
use Illuminate\Http\Request;

class PublicServantController extends Controller
{
    public function index()
    {
        $servants = PublicServant::all();

        return view('public_servants.index', compact('servants'));
    }

    public function create()
    {
        return view('public_servants.create');
    }

    public function store(Request $request)
    {
//        dd(request()->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'registration' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:public_servants',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'job_function' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR',
            'department' => 'required|string|max:120',
            'position' => 'required|string|max:150',
        ]);

        $pulicServant = PublicServant::create($request->all());

        AuditHelper::logCreate($pulicServant, $request);

        return redirect()->route('public_servants.index')->with('success', 'Servidor cadastrado com sucesso.');
    }

    public function show(PublicServant $publicServant)
    {
        return view('public_servants.show', compact('publicServant'));
    }

    public function edit(PublicServant $publicServant)
    {
        return view('public_servants.edit', compact('publicServant'));
    }

    public function update(Request $request, PublicServant $publicServant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'registration' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:public_servants,cpf,' . $publicServant->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'role' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR',
            'active' => 'boolean',
        ]);

        $publicServant->update($request->all());
        return redirect()->route('public_servants.index')->with('success', 'Servidor atualizado com sucesso.');
    }

    public function destroy(PublicServant $publicServant)
    {
        $publicServant->delete();
        return redirect()->route('public_servants.index')->with('success', 'Servidor excluído com sucesso.');
    }
}
