<?php

declare(strict_types=1);

/**
 * Escapa texto para exibição segura em HTML.
 * Neutraliza falhas de XSS ao converter caracteres especiais em entidades.
 */
if (!function_exists('e')) {
    function e(string $texto): string
    {
        return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    }
}
