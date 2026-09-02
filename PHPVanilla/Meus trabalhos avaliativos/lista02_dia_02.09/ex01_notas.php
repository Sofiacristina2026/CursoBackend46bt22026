<?php

declare(strict_types=1);

$notas = [7.5, 8.0, 6.5, 9.0, 5.5];

$soma = 0;

foreach ($notas as $nota) {
    $soma += $nota;
}

$quantidadeNotas = count($notas);

$media = $soma / $quantidadeNotas;

echo "A média final do aluno é: " . $media . "<br>";

if ($media >= 7) {
    echo "<span style='color: green;'>Aprovado</span>";
} else {
    echo "<span style='color: red;'>Reprovado</span>";
}