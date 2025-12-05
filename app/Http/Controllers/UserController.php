<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\PublicServant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use App\Mail\UserRegisterMail;

class UserController
{
    public function index(): View
    {
        // Se for administrador do sistema, mostra todos os usuários
        if (auth()->user()->hasRole('administrador')) {
            $users = User::with(['roles'])->get();
        } else {
            // Caso contrário, filtra os usuários pelo departamento do usuário logado
            $users = User::query()
                ->whereHas('publicServant.departments', function($query) {
                    // Obtém os IDs dos departamentos do usuário logado
                    $departmentIds = auth()->user()->publicServant
                        ->departments()
                        ->wherePivot('is_active', true)
                        ->pluck('departments.id');

                    $query->whereIn('departments.id', $departmentIds);
                })
                ->orWhere('id', auth()->id()) // Inclui o próprio usuário logado
                ->with(['roles'])
                ->get();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'registration' => ['required', 'string', 'max:255', 'unique:'.PublicServant::class],
            'cpf' => ['required', 'string', 'max:14', 'unique:'.PublicServant::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'job_function' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:100'],
        ]);
        $role = Role::where('name', strtolower($request->role))->first();
        $password = null;

        if (empty($role)) {
            return back()->withErrors([
                'role' => 'Perfil não encontrado',
            ]);
        }

        // Se o password for vazio, gera um password aleatório
        if (!empty($request->password)){
            $password = $request->password;
        }else{
            $password = Hash::make($request->password);
        }

        try {
            $userNew = DB::transaction(function () use ($request, $role, $password) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'role_id' => $role->id,
                ]);

                $assigned_by = auth()->user()->id ?? $user->id;

                $user->roles()->attach($role->id, [
                    'assigned_by' => $assigned_by,
                    'assigned_at' => now(),
                    'user_id' => $user->id,
                ]);

                $publicServant = PublicServant::create([
                    'name' => $request->name,
                    'registration' => $request->registration,
                    'cpf' => $request->cpf,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'department' => $request->department,
                    'position' => $request->position,
                    'job_function' => $request->job_function,
                    'active' => true,
                    'user_id' => $user->id,
                ]);

                // Attach department with pivot data( TODO: add values for position, job_function)
                if ($request->department) {
                    $publicServant->departments()->attach($request->department, [
                        'position' => $request->position,
                        'job_function' => $request->job_function,
                        'is_active' => true
                    ]);
                }

                AuditHelper::logCreate($user, $request);

                return $user;
            });
        } catch (\Throwable $e) {
            \Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return back()
                ->withErrors(['message' => 'Ocorreu um erro ao criar o usuário. Tente novamente.'])
                ->withInput();
        }

        // Envia email de boas-vindas/registro caso o usuario seja criado pelo sistema (TODO: TESTAR ESSE CODIGO)
        if(empty($request->isFromEmail)) {
            try {
                Mail::to($userNew->email)->send(new UserRegisterMail([
                    'name' => $userNew->name,
                    'email' => $userNew->email,
                    'role' => $role->display_name ?? $role->name,
                    'registration' => $request->registration,
                ]));
            } catch (\Throwable $e) {
                // Opcional: logar erro, mas não interromper o fluxo de criação
                \Log::error('Erro ao enviar email de cadastro do usuário: ' . $e->getMessage());
            }
        }

        event(new Registered($userNew));

        if (!Auth::check()){
            Auth::login($userNew);
        }

        return redirect(route('dashboard', absolute: false));
    }

    public function sendEmailForm()
    {
        return view('users.send-register-email');
    }


    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'role' => 'required|string|max:20',
        ]);

        Mail::to($data['email'])->send(new UserRegisterMail($data));

        return back()->with('success', 'Sua mensagem foi enviada com sucesso!');
    }

    public function register(Request $request){
        $roles = Role::all();
        $jobFunction = 'ALMOXARIFE';

        if($request->has('perfil') && $request->perfil == 'ADMINISTRATIVO'){
            $jobFunction = 'ADMINISTRADOR';
        }

        return view('users.register',
            [
                'roles' => $roles,
                'tokenRegister' => $request->tokenRegister,
                'perfil' => $request->perfil,
                'email' => $request->email,
                'jobFunction' => $jobFunction,
            ]
        );
    }
}
