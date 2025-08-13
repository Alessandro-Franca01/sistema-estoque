<?php

namespace App\Http\Controllers;

use App\Models\PublicServant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $role = Role::where('name', strtoupper($request->role))->first();

        $userNew = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        // Se tiver configurado no sistema então vai setar assinatua vai ser do proprio usuario criado teste12345
        if(!config('custom.show_link_user_create')){
            $assigned_by = auth()->user()->id;
        }else{
            $assigned_by = $userNew->id;
        }

        $userNew->roles()->attach($role->id, [
            'assigned_by' => $assigned_by,
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

        event(new Registered($userNew));

        if (!Auth::check()){
            Auth::login($userNew);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
