<?php

namespace App\Support;

use App\Models\Department;

class Tenant
{
    private static ?Department $current = null;

    public static function set(?Department $department): void
    {
        self::$current = $department;
    }

    public static function current(): ?Department
    {
        return self::$current;
    }

    public static function id(): ?int
    {
        return self::$current?->id;
    }
}
