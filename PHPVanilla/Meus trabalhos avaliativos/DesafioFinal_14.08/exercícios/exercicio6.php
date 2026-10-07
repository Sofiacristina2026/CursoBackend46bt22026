Exercício 6: Bilheteria Inteligente (Cinema)
O cinema CineSenai possui regras de cobrança cumulativas. Você deve processar a compra de 1 ingresso.

<?php

declare(strict_types=1);

$diaSemana = "Quarta";
$isEstudante = true;
$valorBase = 40.00;

$valorDia = match ($diaSemana) {
    "Segunda", "Terca" => $valorBase * 0.80,
    "Quarta" => $valorBase * 0.50,
    "Quinta", "Sexta", "Sabado", "Domingo" => $valorBase
};

if ($isEstudante) {
    $valorDia = $valorDia * 0.50;
}

echo "Valor final: R$ " . number_format($valorDia, 2, ',', '.');

?>