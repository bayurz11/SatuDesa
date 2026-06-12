<?php

namespace App\Support;

class SpreadsheetValueSanitizer
{
    public static function escape(null|string|int|float $value): null|string|int|float
    {
        if (! is_string($value)) {
            return $value;
        }

        if ($value === '') {
            return $value;
        }

        $firstCharacter = substr($value, 0, 1);

        if (in_array($firstCharacter, ['=', '+', '-', '@'], true)) {
            return "'" . $value;
        }

        return $value;
    }
}
