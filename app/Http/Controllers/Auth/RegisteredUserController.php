<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PublicServant;
use App\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::all();

        return view('auth.register', compact('roles'));

    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);
//      TODO: Assinar com o ID do usuario que enviou o email
        $assigned_by = null;
        $assigned_by = $user->id;

        $user->roles()->attach($role->id, [
                'assigned_by' => $assigned_by,
                'assigned_at' => now(),
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

        event(new Registered($user));

        if (!Auth::check()){
            Auth::login($user);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
