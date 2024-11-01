<?php

namespace App\Utils;

class NormalizeUTF8
{
    /**
     * Normaliza a codificação UTF-8 em um array de entrada.
     *
     * @param array $input
     * @return array
     */
    public static function normalizeArray(array $input): array
    {
        array_walk_recursive($input, function (&$value) {
            if (!mb_check_encoding($value, 'UTF-8')) {
                $value = mb_convert_encoding($value, 'UTF-8');
            }
        });

        return $input;
    }

    /**
     * Normaliza uma string para UTF-8.
     *
     * @param string $input
     * @return string
     */
    public static function normalizeString(string $input): string
    {
        $encoding = mb_detect_encoding($input, ['UTF-8', 'ISO-8859-1', 'WINDOWS-1252'], true);
        if ($encoding !== 'UTF-8') {
            $input = mb_convert_encoding($input, 'UTF-8', $encoding);
        }

        return $input;
    }
}
