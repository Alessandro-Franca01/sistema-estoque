<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\PublicServant;
use App\Models\Department;
use App\Support\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PublicServantController extends Controller
{
    public function index()
    {
        // Lista apenas os servidores vinculados ao Department (tenant)
        $servants = PublicServant::query()
            ->whereHas('departments', function ($q) {
                if (Tenant::id()) {
                    $q->where('departments.id', Tenant::id());
                }
            })
//            ->whereDoesntHave('user') // TODO: NÃO ESTÁ FUNCIONANDO!
            ->with(['departments' => function ($q) {
                if (Tenant::id()) {
                    $q->where('departments.id', Tenant::id());
                }
            }])
            ->orderBy('name')
            ->paginate(5);

        return view('public_servants.index', compact('servants'));
    }

    public function create()
    {
        $tenantId = Tenant::id();
        $departments = Department::where('id', '=', $tenantId)->get();

        return view('public_servants.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration' => 'required|string|max:255|unique:public_servants,registration',
            'cpf' => 'required|string|size:11|unique:public_servants,cpf',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'job_function' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR,ADMINISTRADOR',
            'department_id' => 'required|exists:departments,id',
            'position' => 'nullable|string|max:150',
        ]);

        $pulicServant = PublicServant::create([
            'name' => $validated['name'],
            'registration' => $validated['registration'],
            'cpf' => $validated['cpf'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'user_id' => auth()->id(),
        ]);

        // Vincula ao departamento via pivô
        $pulicServant->departments()->attach((int) $validated['department_id'], [
            'position' => $validated['position'] ?? null,
            'job_function' => $validated['job_function'],
            'is_active' => true,
        ]);

        AuditHelper::logCreate($pulicServant, $request);

        return redirect()->route('public_servants.index')->with('success', 'Servidor cadastrado com sucesso.');
    }

    public function show(PublicServant $publicServant)
    {
        return view('public_servants.show', compact('publicServant'));
    }

    public function edit(PublicServant $publicServant)
    {
        // Eager load do vínculo com o tenant atual
        $publicServant->load(['departments' => function ($q) {
            if (Tenant::id()) {
                $q->where('departments.id', Tenant::id());
            }
        }]);

        $departments = Department::active()->orderBy('name')->get();
        return view('public_servants.edit', compact('publicServant', 'departments'));
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
                // Não atualiza pivô via perfil
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'registration' => 'required|string|max:255',
                'cpf' => 'required|string|size:11|unique:public_servants,cpf,' . $publicServant->id,
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'job_function' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR,ADMINISTRADOR',
                'department_id' => 'required|exists:departments,id',
                'position' => 'nullable|string|max:150',
                'is_active' => 'nullable|boolean',
            ]);
        }

        // Captura os valores anteriores antes da atualização
        $original = $publicServant->getOriginal();

        // Atualiza somente os campos esperados
        $publicServant->update([
            'name' => $validated['name'],
            'registration' => $validated['registration'],
            'cpf' => $validated['cpf'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        // Atualiza dados do pivô quando vindo do formulário geral (não perfil)
        if (!$request->boolean('from_profile')) {
            $depId = (int) $validated['department_id'];
            // garanta vínculo
            if (!$publicServant->departments()->where('departments.id', $depId)->exists()) {
                $publicServant->departments()->attach($depId, [
                    'position' => $validated['position'] ?? null,
                    'job_function' => $validated['job_function'],
                    'is_active' => array_key_exists('is_active', $validated) ? (bool)$validated['is_active'] : true,
                ]);
            } else {
                $publicServant->departments()->updateExistingPivot($depId, [
                    'position' => $validated['position'] ?? null,
                    'job_function' => $validated['job_function'],
                    'is_active' => array_key_exists('is_active', $validated) ? (bool)$validated['is_active'] : $publicServant->departments()->where('departments.id', $depId)->first()->pivot->is_active,
                ]);
            }
        }

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
}
