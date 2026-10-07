<?php

declare(strict_types=1);

// Mostra uma mensagem para perguntar ao cliente qual a categoria dele. Ai ele responde pelo FrontEnd
echo "Digite a categoria do cliente: ";

// Dados iniciais do cliente
// Aqui estou definindo a categoria, o valor da dívida e quantos meses ela está atrasada
$categoriaCliente = 'A';
$saldoDevedor = 1000.00;
$mesesAtraso = 12;

// Eu usei o match para verifica qual é a categoria do cliente
// Cada categoria possui uma porcentagem de juros diferente
$taxaJuros = match ($categoriaCliente) {
    'A' => 0.01, // Categoria A = 1% de juros
    'B' => 0.02, // Categoria B = 2% de juros
    'C' => 0.03, // Categoria C = 3% de juros
    default => 0.05, // Se não for A, B ou C = 5% de juros
};

// O for eu usei para repetir o cálculo durante os 12 meses de atraso
for ($i = 1; $i <= $mesesAtraso; $i++) {

    //Depois só Calcula o valor dos juros daquele mês
    $jurosMes = $saldoDevedor * $taxaJuros;

    // Soma os juros ao valor atual que ta devendo
    // Assim, no próximo mês os juros serão calculados sobre o novo valor
    $saldoDevedor = $saldoDevedor + $jurosMes;

    // Mostra na tela o valor da dívida depois dos juros de cada mês
    // number_format deixa o valor no formato de dinheiro brasileiro
    echo "\nValor ao final do mês $i: R$ "
        . number_format($saldoDevedor, 2, ",", ".");
}