<?php

namespace App\Http\Middleware;

use App\Models\Department;
use App\Support\Tenant;
use Closure;
use Illuminate\Http\Request;

class SetCurrentDepartment
{
    public function handle(Request $request, Closure $next)
    {
        $deptId = $request->session()->get('department_id');

        // Fallback: tenta inferir do usuário logado
        if (!$deptId && auth()->check()) {
            $deptId = optional(
                auth()->user()?->publicServant?->departments()->wherePivot('is_active', true)->first()
            )?->id;
        }

        if ($deptId) {
            $department = Department::find($deptId);
            Tenant::set($department);
        } else {
            Tenant::set(null);
        }

        return $next($request);
    }
}
