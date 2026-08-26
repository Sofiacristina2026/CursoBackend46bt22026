<?php

declare(strict_types=1);

function aplicarDesconto(float &$preco, float $porcentagem): void
{
    $desconto = $preco * ($porcentagem / 100);
    $preco = $preco - $desconto;
}

$preco = 200.00;

echo "Preço antes do desconto: R$ " . number_format($preco, 2, ",", ".") . "<br>";

aplicarDesconto($preco, 15);

echo "Preço depois do desconto: R$ " . number_format($preco, 2, ",", ".");