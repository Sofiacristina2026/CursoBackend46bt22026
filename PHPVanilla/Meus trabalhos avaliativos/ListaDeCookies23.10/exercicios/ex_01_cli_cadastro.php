
<?php
declare(strict_types=1);

require_once __DIR__ . '/UsuarioDAO.php';

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
$nome = readline('Nome: ');
$email = readline('E-mail: ');
$senha = readline('Senha: ');

if (!senhaValida($senha)) {
    exit("Senha fraca! Verifique os requisitos.\n");
}

// Gera o hash seguro e cadastra o usuário.
$hash = password_hash($senha, PASSWORD_ARGON2ID);
$dao = new UsuarioDAO(conectar());

try {
    $dao->cadastrar($nome, $email, $hash);
    echo "Colaborador cadastrado com sucesso!\n";
} catch (PDOException $erro) {
    echo "Não foi possível cadastrar. Verifique os dados.\n";
}
