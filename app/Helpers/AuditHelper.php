<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditHelper
{
    /**
     * Registra uma ação de criação
     */
    public static function logCreate(Model $model, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return AuditLog::record(
            event: AuditLog::EVENT_CREATED,
            auditable: $model,
            newValues: $model->toArray(),
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    public static function logCreateCustomData(Model $model, ?Request $request = null, array $additionalData = [], array $data, bool $isCustomData = true): AuditLog
    {
        return AuditLog::record(
            event: AuditLog::EVENT_CREATED,
            auditable: $model,
            newValues: $data,
            request: $request ?? request(),
            additionalData: $additionalData,
            isCustomData: $isCustomData
        );
    }

    /**
     * Registra uma ação de atualização
     */
    public static function logUpdate(Model $model, array $changes, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return AuditLog::record(
            event: AuditLog::EVENT_UPDATED,
            auditable: $model,
            oldValues: array_intersect_key($model->getOriginal(), $changes),
            newValues: $changes,
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    /**
     * Registra uma ação de exclusão
     */
    public static function logDelete(Model $model, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return AuditLog::record(
            event: AuditLog::EVENT_DELETED,
            auditable: $model,
            oldValues: $model->toArray(),
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    /**
     * Registra uma ação de visualização
     */
    public static function logView(Model $model, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return AuditLog::record(
            event: AuditLog::EVENT_VIEWED,
            auditable: $model,
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    /**
     * Registra um evento personalizado
     */
    public static function logEvent(
        string $event,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null,
        array $additionalData = []
    ): AuditLog {
        return AuditLog::record(
            event: $event,
            auditable: $model,
            oldValues: $oldValues,
            newValues: $newValues,
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    /**
     * Registra um login bem-sucedido
     */
    public static function logLogin(Model $user, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return self::logEvent(
            event: AuditLog::EVENT_LOGIN,
            model: $user,
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }

    /**
     * Registra um logout
     */
    public static function logLogout(Model $user, ?Request $request = null, array $additionalData = []): AuditLog
    {
        return self::logEvent(
            event: AuditLog::EVENT_LOGOUT,
            model: $user,
            request: $request ?? request(),
            additionalData: $additionalData
        );
    }
}
