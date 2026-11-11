<?php
declare(strict_types=1);

// Recebe a senha pelo terminal.
$senha = readline('Digite uma senha: ');

// Gera o hash utilizando Argon2id.
$hash = password_hash($senha, PASSWORD_ARGON2ID);

// Separa os blocos do hash.
$partes = explode('$', $hash);

if ($partes[1] === 'argon2id') {
    echo "\nALGORITMO: {$partes[1]}\n";
    echo "VERSÃO: {$partes[2]}\n";
    echo "CUSTOS: {$partes[3]}\n";
    echo "SALT CODIFICADO: {$partes[4]}\n";
    echo "HASH FINAL: {$partes[5]}\n";
} else {
    echo "Formato de hash não reconhecido.\n";
}
