<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

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
        'created_at' => 'datetime'
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related auditable model.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to filter by event type.
     */
    public function scopeEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope a query to filter by auditable type.
     */
    public function scopeAuditableType($query, $type)
    {
        return $query->where('auditable_type', $type);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Helper method to log an audit event.
     */
    public static function log(string $event, Model $auditable, array $oldValues = null, array $newValues = null, array $additionalData = [])
    {
        $data = [
            'event' => $event,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => request()?->fullUrl(),
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->header('User-Agent'),
            'user_id' => auth()->id(),
        ];

        return static::create(array_merge($data, $additionalData));
    }
}
