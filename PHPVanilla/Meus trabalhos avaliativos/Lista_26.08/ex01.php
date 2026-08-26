<?php

declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

$imc1 = calcularIMC(60, 1.65);
$imc2 = calcularIMC(70, 1.70);
$imc3 = calcularIMC(80, 1.75);

echo "IMC 1: " . number_format($imc1, 2) . PHP_EOL;
echo "IMC 2: " . number_format($imc2, 2) . PHP_EOL;
echo "IMC 3: " . number_format($imc3, 2) . PHP_EOL;