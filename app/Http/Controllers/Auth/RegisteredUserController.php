<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\PublicServant;
use App\Models\Role;
use App\Models\Department;
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
        $departments = Department::active()->orderBy('name')->get();

        return view('auth.register', compact('roles', 'departments'));
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
            'department_id' => ['required', 'exists:departments,id'],
            'position' => ['nullable', 'string', 'max:255'],
            'job_function' => ['required', 'in:ADMINISTRADOR,ALMOXARIFE,OPERADOR,SERVIDOR'],
            'role' => ['required', 'string', 'max:100'],

        ]);
        $role = Role::where('name', strtoupper($request->role))->first();

        $user = DB::transaction(function () use ($request, $role) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $role->id,
            ]);

            // registra papel com metadados
            $user->roles()->attach($role->id, [
                'assigned_by' => $user->id,
                'assigned_at' => now(),
            ]);

            // cria servidor público
            $publicServant = PublicServant::create([
                'name' => $request->name,
                'registration' => $request->registration,
                'cpf' => $request->cpf,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);

            // vincula ao departamento com dados do pivô
            $publicServant->departments()->attach($request->integer('department_id'), [
                'position' => $request->input('position'),
                'job_function' => $request->input('job_function'),
                'is_active' => true,
            ]);

            return $user;
        });

        event(new Registered($user));

        if (!Auth::check()){
            Auth::login($user);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
