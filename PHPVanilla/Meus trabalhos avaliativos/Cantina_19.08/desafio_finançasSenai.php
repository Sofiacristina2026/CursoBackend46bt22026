```php
<?php
echo: "Digite a categoria do cliente";

declare(strict_types=1);

// Dados dos clientes
$categoriaCliente = 'A';
$saldoDevedor = 1000.00;
$mesesAtraso = 12;

// Classificação o juros de acordo com a classe de cada pessoa
$taxaJuros = match ($categoriaCliente) {
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05,
//O match funciona basicamente como: "Qual é a categoria desse cliente? Dependendo da resposta, escolha uma taxa."
};

//Demonstrar a Evolução da Divida ao Longo de 12 meses
//RF02 -> 
for ($i=1; $i <= $mesesAtraso; $i++) { 

    //Regra Especial : Anistia no mês do juros 6 => RF-03
    if($i===6){
        echo "\nValor ao final do mês $i " . number_format($saldoDevedor,2,",",".");
        continue;
    }
    $jurosMes = $saldoDevedor * $txJuros;
    $saldoDevedor = $saldoDevedor + $jurosMes;

    

     echo "\nValor ao final do mês $i " . number_format($saldoDevedor,2,",",".");
}


