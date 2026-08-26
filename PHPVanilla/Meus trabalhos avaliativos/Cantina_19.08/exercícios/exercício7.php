<?php

declare(strict_types=1);

function calcularMedia(array $notas): float
{
    return array_sum($notas) / count($notas);
}

function verificarAprovacao(float $media): string
{
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

$notas = [8, 7, 9, 6];

$media = calcularMedia($notas);
$status = verificarAprovacao($media);

echo "Média: " . $media . "<br>";
echo "Status: " . $status . "<br>";
echo "Maior nota: " . max($notas) . "<br>";
echo "Menor nota: " . min($notas);
?>