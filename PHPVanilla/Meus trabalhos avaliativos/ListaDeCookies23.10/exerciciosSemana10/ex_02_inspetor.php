<?php
declare(strict_types=1);

// Recebe uma senha pelo terminal.
$senha = readline('Digite uma senha para analisar: ');

// Gera o hash usando Argon2id.
$hash = password_hash($senha, PASSWORD_ARGON2ID);

// Separa os componentes do hash.
$partes = explode('$', $hash);

echo "\n===== INSPETOR DE HASH =====\n";
echo "Hash completo: $hash\n";
echo "Algoritmo: {$partes[1]}\n";
echo "Versão: " . explode('=', $partes[2])[1] . "\n";

// Separa os custos de memória, tempo e paralelismo.
$parametros = explode(',', $partes[3]);

echo "Custo de memória: {$parametros[0]}\n";
echo "Custo de tempo: {$parametros[1]}\n";
echo "Paralelismo: {$parametros[2]}\n";

echo "Salt codificado em Base64: {$partes[4]}\n";
echo "Hash final: {$partes[5]}\n";

echo "\nAnálise concluída!\n";
