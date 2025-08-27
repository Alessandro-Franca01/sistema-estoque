<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeNewUser;
use App\Models\PublicServant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class UserController
{
    public function index(): View
    {
        $users = User::all();

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

        // TODO 1: USAR TRANSACTION PARA GARANTIR QUE TODOS OS REGISTROS SEJAM FEITOS OU NENHUM SEJA FEITO
        $role = Role::where('name', strtoupper($request->role))->first();
        $temporaryPassword = Str::random(12);
        $userNew = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'role_id' => $role->id,
        ]);

        $userNew->roles()->attach($role->id, [
            'assigned_by' => auth()->user()->id,
            'assigned_at' => now(),
            'user_id' => $userNew->id,
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
            'user_id' => $userNew->id,
        ]);
        // TODO 2: IMPLEMENTAR A AUDITORIA NESSE FLUXO

        // TODO 3: FAZER UM TESTE EM PRODUÇÃO PARA VERIFICAR SE O EVENTO É EXECUTADO COM O JOB E QUEQUE
        event(new Registered($userNew));

        // Enviar email de boas-vindas com credenciais
        try {
            Mail::to($user->email)->send(new WelcomeNewUser($user, $temporaryPassword));
        } catch (\Exception $e) {
            // Log do erro, mas não interrompe o processo de registro
            \Log::error('Erro ao enviar email de boas-vindas: ' . $e->getMessage());
        }

        return redirect(route('dashboard', absolute: false));
    }

    public function formToSendEmail()
    {
        return view('users.send_email');
    }

    public function sendEmail()
    {

    }
}
