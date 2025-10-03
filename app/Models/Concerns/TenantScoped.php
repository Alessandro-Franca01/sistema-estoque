<?php

namespace App\Models\Concerns;

use App\Support\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait TenantScoped
{
    public static function bootTenantScoped(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $deptId = Tenant::id();
            if ($deptId) {
                $builder->where($builder->getModel()->getTable().'.department_id', $deptId);
            }
        });

        static::creating(function ($model) {
            if (empty($model->department_id) && Tenant::id()) {
                $model->department_id = Tenant::id();
            }
        });
    }

    public function scopeWithoutTenant($query)
    {
        return $query->withoutGlobalScope('tenant');
    }
}
