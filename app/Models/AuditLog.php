<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class AuditLog extends Model
{
    const UPDATED_AT = null;

    use HasFactory;

    /**
     * Eventos pré-definidos para padronização
     */
    public const EVENT_CREATED = 'created';
    public const EVENT_UPDATED = 'updated';
    public const EVENT_DELETED = 'deleted';
    public const EVENT_VIEWED = 'viewed';
    public const EVENT_EXPORTED = 'exported';
    public const EVENT_LOGIN = 'login';
    public const EVENT_LOGOUT = 'logout';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Relação com o usuário que realizou a ação
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação polimórfica com o modelo auditado
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope para filtrar por tipo de evento
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope para filtrar por modelo auditado
     */
    public function scopeForModel($query, string $modelClass)
    {
        return $query->where('auditable_type', $modelClass);
    }

    /**
     * Scope para filtrar por ID do modelo auditado
     */
    public function scopeForModelId($query, $modelId)
    {
        return $query->where('auditable_id', $modelId);
    }

    /**
     * Scope para filtrar por usuário
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para filtrar por intervalo de datas
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope para filtrar por tag
     */
    public function scopeWithTag($query, string $tag)
    {
        return $query->where('tags', 'like', "%{$tag}%");
    }

    /**
     * Método estático para registrar um novo log de auditoria
     *
     * @param string $event Tipo de evento
     * @param Model|null $auditable Modelo relacionado
     * @param array|null $oldValues Valores antigos (para updates)
     * @param array|null $newValues Valores novos
     * @param Request|null $request Objeto da requisição
     * @param array $additionalData Dados adicionais
     * @return AuditLog
     */
    public static function record(
        string $event,
        ?Model $auditable = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null,
        array $additionalData = [],
        ?bool $isCustomData = false
    ): AuditLog {
        $data = [
            'event' => $event,
            'url' => $request?->fullUrl(),
            'ip_address' => $request?->ip() ?? 'cli',
            'user_agent' => $request?->userAgent(),
            'user_id' => auth()->id(),
        ];

        if ($auditable) {
            $data['auditable_type'] = get_class($auditable);
            $data['auditable_id'] = $auditable->id;
        }

        if ($oldValues) {
            $data['old_values'] = $oldValues;
        }

        if ($newValues) {
            $data['new_values'] = $newValues;

            if (!empty($isCustomData)) {
                $data['new_values'] = json_encode($newValues);
            }
        }

        return static::create(array_merge($data, $additionalData));
    }

    /**
     * Formata os valores antigos/novos para exibição
     */
    public function getFormattedOldValuesAttribute(): string
    {
        return $this->formatValues($this->old_values);
    }

    /**
     * Formata os valores antigos/novos para exibição
     */
    public function getFormattedNewValuesAttribute(): string
    {
        return $this->formatValues($this->new_values);
    }

    /**
     * Método auxiliar para formatar os valores para exibição
     */
    protected function formatValues(?array $values): string
    {
        if (empty($values)) {
            return 'N/A';
        }

        $formatted = [];
        foreach ($values as $key => $value) {
            $formatted[] = "{$key}: " . (is_array($value) ? json_encode($value) : $value);
        }

        return implode("\n", $formatted);
    }
}
