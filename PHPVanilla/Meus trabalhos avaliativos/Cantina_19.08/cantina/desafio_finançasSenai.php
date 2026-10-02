<?php
declare(strict_types=1);

echo "Digite a categoria do cliente";

// Dados dos clientes
$categoriaCliente = 'A';
$saldoDevedor = 1000.00;
$mesesAtraso = 12;

// Classificação dos juros de acordo com a classe de cada pessoa
$taxaJuros = match ($categoriaCliente) {
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05,
};

// Demonstrar a evolução da dívida ao longo de 12 meses
for ($i = 1; $i <= $mesesAtraso; $i++) {

    // Regra especial: anistia no mês 6
    if ($i === 6) {
        echo "\nValor ao final do mês $i " . number_format($saldoDevedor, 2, ",", ".");
        continue;
    }

    $jurosMes = $saldoDevedor * $taxaJuros;
    $saldoDevedor = $saldoDevedor + $jurosMes;

    echo "\nValor ao final do mês $i " . number_format($saldoDevedor, 2, ",", ".");
}