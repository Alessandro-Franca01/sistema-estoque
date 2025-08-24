<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\PublicServant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PublicServantController extends Controller
{
    public function index()
    {
        $servants = PublicServant::orderBy('name')->paginate(5);

        return view('public_servants.index', compact('servants'));
    }

    public function create()
    {
        return view('public_servants.create');
    }

    public function store(Request $request)
    {
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
        // Quando vier do formulário de perfil, normaliza campos mascarados (mantém apenas dígitos)
        if ($request->boolean('from_profile')) {
            $normalized = [];
            if ($request->has('cpf')) {
                $normalized['cpf'] = preg_replace('/\D/', '', (string) $request->input('cpf'));
            }
            if ($request->has('registration')) {
                $normalized['registration'] = preg_replace('/\D/', '', (string) $request->input('registration'));
            }
            if ($request->has('phone')) {
                $normalized['phone'] = preg_replace('/\D/', '', (string) $request->input('phone'));
            }
            if (!empty($normalized)) {
                $request->merge($normalized);
            }
        }

        // Validação condicional: quando a atualização vier do perfil, exigimos apenas um subconjunto de campos
        if ($request->boolean('from_profile')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'registration' => 'required|string|max:255',
                'cpf' => 'required|string|size:11|unique:public_servants,cpf,' . $publicServant->id,
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                // Os campos abaixo não são exibidos no formulário de perfil, então não obrigamos
                'department' => 'nullable|string|max:120',
                'position' => 'nullable|string|max:150',
                'job_function' => 'nullable|in:OPERADOR,ALMOXARIFE,SERVIDOR',
                'active' => 'nullable|boolean',
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'registration' => 'required|string|max:255',
                'cpf' => 'required|string|size:11|unique:public_servants,cpf,' . $publicServant->id,
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'job_function' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR',
                'department' => 'required|string|max:120',
                'position' => 'required|string|max:150',
                'active' => 'boolean',
            ]);
        }

        // Captura os valores anteriores antes da atualização
        $original = $publicServant->getOriginal();

        // Atualiza somente os campos esperados
        $publicServant->update($validated);

        // Calcula alterações com base no original
        $current = $publicServant->getAttributes();
        $changes = array_diff_assoc($current, $original);
        $oldValues = array_intersect_key($original, $changes);

        if (!empty($changes)) {
            // Registra auditoria com dados antigos corretos
            AuditHelper::logUpdateCustomData($publicServant, $changes, $request, [], $oldValues, true);
        }

        // Redireciona conforme a origem
        if ($request->boolean('from_profile')) {
            return redirect()->route('profile.edit')->with('status', 'public-servant-updated');
        }

        return redirect()->route('public_servants.index')->with('success', 'Servidor atualizado com sucesso.');
    }

    public function destroy(PublicServant $publicServant)
    {
        $publicServant->delete();
        return redirect()->route('public_servants.index')->with('success', 'Servidor excluído com sucesso.');
    }
}
