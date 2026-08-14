Exercício 5: Calculadora de Tarifas Logísticas
Uma transportadora cobra valores diferentes por região. Use a expressão match (não use if/else nem switch) para resolver.

<?php

declare(strict_types=1);

$siglaEstado = "SP";

$valorFrete = match ($siglaEstado) {
    "SP", "RJ", "MG", "ES" => 35.00,
    "PR", "SC", "RS" => 45.00,
    "BA", "CE", "PE" => 60.00,
    default => 80.00
};

echo "Para o estado $siglaEstado, o frete é R$ " . number_format($valorFrete, 2, ',', '.');

?>