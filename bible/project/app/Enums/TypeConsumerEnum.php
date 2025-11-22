<?php

namespace App\Enums;

enum TypeConsumerEnum: string
{
    case STUDENT = 'student';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::STUDENT => 'Студенту',
            self::OTHER => 'Прочим',
        };
    }

    public static function options(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }
}
