<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'public_servant_id',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()
            ->where('name', $role)
            ->where('is_active', true) // Considera apenas roles ativas
            ->exists();
    }

    /**
     * Verifica se o usuário possui qualquer um dos papéis informados.
     * Aceita array de strings ou múltiplos argumentos string.
     */
    public function hasAnyRole(array|string ...$roles): bool
    {
        // Permitir chamada com um array: hasAnyRole(['admin', 'user'])
        if (count($roles) === 1 && is_array($roles[0])) {
            $roles = $roles[0];
        }

        if (empty($roles)) {
            return false;
        }

        return $this->roles()
            ->whereIn('name', $roles)
            ->where('is_active', true)
            ->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function($query) use ($permission) {
                $query->where('name', $permission);
            })->exists();
    }

    public function isAlmoxarife(): bool
    {
        return $this->hasRole(Role::ALMOXARIFE);
    }

    public function isAdministrativo(): bool
    {
        return $this->hasRole(Role::ADMINISTRATIVO);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',  // tabela pivot
            'user_id',     // FK em user_roles para User
            'role_id',     // FK em user_roles para Role
            'id',          // PK em User
            'id'           // PK em Role
        )->withPivot(['assigned_by', 'assigned_at']); // campos adicionais na pivot
    }

    public function publicServant()
    {
        return $this->hasOne(PublicServant::class, 'user_id');
    }
}
