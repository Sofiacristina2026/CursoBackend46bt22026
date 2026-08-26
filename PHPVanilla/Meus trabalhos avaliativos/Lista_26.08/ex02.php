<?php

declare(strict_types=1);

function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return "Abaixo do peso";
    } elseif ($imc <= 24.9) {
        return "Peso normal";
    } elseif ($imc <= 29.9) {
        return "Sobrepeso";
    } else {
        return "Obesidade";
    }
}

echo classificarIMC(17.5) . PHP_EOL;
echo classificarIMC(22.0) . PHP_EOL;
echo classificarIMC(27.0) . PHP_EOL;
echo classificarIMC(32.0) . PHP_EOL;