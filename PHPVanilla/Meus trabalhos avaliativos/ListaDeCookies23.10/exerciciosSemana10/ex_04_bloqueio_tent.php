<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../UsuarioDAO.php';

// Inicializa as variáveis da sessão.
$_SESSION['tentativas_login'] ??= 0;
$_SESSION['bloqueado_ate'] ??= 0;

// Conecta ao banco de dados.
$pdo = conectar();
$dao = new UsuarioDAO($pdo);

echo "===== LOGIN SEGURO =====\n";

while (true) {

    // Verifica se o usuário está bloqueado.
    $restante = $_SESSION['bloqueado_ate'] - time();

    if ($restante > 0) {
        echo "\nAcesso bloqueado! Aguarde:\n";

        while ($restante > 0) {
            echo "\rTempo restante: {$restante} segundos ";
            sleep(1);
            $restante--;
        }

        $_SESSION['bloqueado_ate'] = 0;
        echo "\nBloqueio encerrado!\n";
    }

    // Recebe os dados pelo terminal.
    echo "\nE-mail: ";
    $email = trim((string) fgets(STDIN));

    echo "Senha: ";
    $senha = trim((string) fgets(STDIN));

    // Consulta o usuário no banco.
    $usuario = $dao->buscarPorEmail($email);

    $sucesso = $usuario !== null
        && isset($usuario['senha_hash'])
        && password_verify($senha, $usuario['senha_hash']);

    if ($sucesso) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'email' => $usuario['email'],
            'perfil' => $usuario['perfil'],
        ];

        $_SESSION['tentativas_login'] = 0;
        $_SESSION['bloqueado_ate'] = 0;

        echo "\nLogin realizado com sucesso!\n";
        break;
    }

    // Contabiliza as tentativas incorretas.
    $_SESSION['tentativas_login']++;

    echo "\nE-mail ou senha incorretos!\n";

    if ($_SESSION['tentativas_login'] >= 3) {
        $_SESSION['bloqueado_ate'] = time() + 60;
        $_SESSION['tentativas_login'] = 0;

        echo "Muitas tentativas! Bloqueio de 60 segundos.\n";
    } else {
        echo "Tentativas restantes: "
            . (3 - $_SESSION['tentativas_login']) . "\n";
    }
}

session_write_close();
