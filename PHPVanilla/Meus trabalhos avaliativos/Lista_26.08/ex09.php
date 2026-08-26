<?php

declare(strict_types=1);

function buscarCliente(array $clientes, string $nome): ?array
{
    foreach ($clientes as $cliente) {
        if ($cliente["nome"] === $nome) {
            return $cliente;
        }
    }

    return null;
}

$clientes = [
    ["nome" => "Maria", "idade" => 20],
    ["nome" => "João", "idade" => 25],
    ["nome" => "Pedro", "idade" => 30]
];

// Cliente encontrado
$cliente = buscarCliente($clientes, "João");

if ($cliente !== null) {
    echo "Cliente encontrado: " . $cliente["nome"] . "<br>";
    echo "Idade: " . $cliente["idade"] . "<br>";
} else {
    echo "Cliente não encontrado.<br>";
}

// Cliente não encontrado
$cliente = buscarCliente($clientes, "Ana");

if ($cliente !== null) {
    echo "Cliente encontrado: " . $cliente["nome"];
} else {
    echo "Cliente não encontrado.";
}