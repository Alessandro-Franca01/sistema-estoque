<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'module',
        'action',
        'description'
    ];

    // Módulos do sistema
    const MODULE_PRODUCTS = 'products';
    const MODULE_CATEGORIES = 'categories';
    const MODULE_SUPPLIERS = 'suppliers';
    const MODULE_ENTRIES = 'entries';
    const MODULE_OUTPUTS = 'outputs';
    const MODULE_INVENTORIES = 'inventories';
    const MODULE_CALLS = 'calls';
    const MODULE_REPORTS = 'reports';
    const MODULE_USERS = 'users';
    const MODULE_ROLES = 'roles';
    const MODULE_AUDIT = 'audit';

    // Ações possíveis
    const ACTION_CREATE = 'create';
    const ACTION_READ = 'read';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_APPROVE = 'approve';
    const ACTION_CANCEL = 'cancel';
    const ACTION_EXPORT = 'export';
    const ACTION_VIEW_SENSITIVE = 'view_sensitive';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}