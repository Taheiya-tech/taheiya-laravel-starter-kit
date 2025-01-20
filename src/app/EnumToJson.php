<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App;

use BackedEnum;

class EnumToJson
{
    /**
     * Format enum cases into an array of associative arrays.
     *
     * @param array<BackedEnum> $enumCases
     * @return array
     */
    public static function formatEnumCases(array $enumCases): array
    {
        return array_map(
            function (BackedEnum $enum) {
                // Format the enum name to have only the first character capitalized
                $formattedName = ucfirst(strtolower($enum->name));

                // Return an associative array with the enum value as the key and the formatted name as the value
                return ["key" => $formattedName, "value" => $enum->value];
            },
            $enumCases
        );
    }
}