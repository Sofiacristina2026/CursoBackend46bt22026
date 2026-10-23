
<?php
declare(strict_types=1);

// Lê a senha sem armazená-la em um arquivo.
$senha = readline('Digite uma senha para analisar: ');

// Gera o hash usando Argon2id.
$hash = password_hash($senha, PASSWORD_ARGON2ID);

// Separa o hash em seus componentes.
$partes = explode('$', $hash);

echo "\nHash gerado: $hash\n";
echo "Algoritmo: {$partes[1]}\n";

if (isset($partes[2])) {
    echo "Versão e parâmetros: {$partes[2]}\n";
}

if (isset($partes[3])) {
    echo "Salt codificado: {$partes[3]}\n";
}

if (isset($partes[4])) {
    echo "Hash final codificado: {$partes[4]}\n";
}

// Explica como interpretar os parâmetros.
echo "\nO hash contém algoritmo, parâmetros, salt e resultado.\n";
echo "No Argon2id, os parâmetros indicam memória, tempo e paralelismo.\n";
