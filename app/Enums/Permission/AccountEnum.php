<?php

namespace App\Enums\Permission;

enum AccountEnum: string
{
    case EDIT = 'edit account';
    case DELETE = 'delete account';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
