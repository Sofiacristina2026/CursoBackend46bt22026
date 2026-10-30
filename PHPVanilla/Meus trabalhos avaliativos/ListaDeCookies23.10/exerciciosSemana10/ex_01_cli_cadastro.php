<?php
declare(strict_types=1);

require_once __DIR__ . '/../UsuarioDAO.php';

// Verifica se a senha possui todos os requisitos.
function senhaValida(string $senha): bool
{
    return strlen($senha) >= 8
        && preg_match('/[A-Z]/', $senha) === 1
        && preg_match('/[a-z]/', $senha) === 1
        && preg_match('/[0-9]/', $senha) === 1
        && preg_match('/[^a-zA-Z0-9]/', $senha) === 1;
}

// Recebe os dados pelo terminal.
$nome = trim(readline('Nome: '));
$email = trim(readline('E-mail: '));
$senha = readline('Senha: ');

if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Nome ou e-mail inválido!\n");
}

if (!senhaValida($senha)) {
    exit("Senha fraca! Verifique os requisitos.\n");
}

try {
    // Gera o hash seguro da senha.
    $hash = password_hash($senha, PASSWORD_ARGON2ID);

    $dao = new UsuarioDAO(conectar());
    $dao->cadastrar($nome, $email, $hash);

    echo "Colaborador cadastrado com sucesso!\n";
} catch (PDOException $erro) {
    echo "Não foi possível cadastrar. Verifique os dados.\n";
}
