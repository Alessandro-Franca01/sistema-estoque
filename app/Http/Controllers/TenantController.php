<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        // Opcional: checar se o usuário tem acesso a esse department
        // if (auth()->user()->cannot('switch-department', Department::class)) { abort(403); }

        $department = Department::find($request->integer('department_id'));
        session(['department_id' => $department->id]);

        return back()->with('status', 'Departamento alterado para: '.$department->name);
    }
}
