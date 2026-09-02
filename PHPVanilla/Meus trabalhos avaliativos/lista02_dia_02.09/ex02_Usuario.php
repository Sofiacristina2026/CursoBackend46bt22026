<?php

declare(strict_types=1);

$usuario = [
    "nome" => "Carlos Eduardo",
    "idade" => 28,
    "cidade" => "Americana",
    "estado" => "SP",
    "premium" => true
];

$estrela = "";

if ($usuario["premium"] === true) {
    $estrela = " ⭐";
}

echo "<div style='border: 1px solid black; padding: 20px; width: 300px;'>";
echo "<h2>" . $usuario["nome"] . $estrela . "</h2>";
echo "<p>Idade: " . $usuario["idade"] . "</p>";
echo "<p>Localização: " . $usuario["cidade"] . " - " . $usuario["estado"] . "</p>";
echo "</div>";
