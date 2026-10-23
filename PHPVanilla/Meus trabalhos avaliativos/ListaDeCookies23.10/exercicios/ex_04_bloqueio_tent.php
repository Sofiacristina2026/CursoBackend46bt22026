
<?php
declare(strict_types=1);

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

require_once __DIR__ . '/UsuarioDAO.php';

// Inicializa o controle de tentativas.
$_SESSION['tentativas_login'] ??= 0;
$_SESSION['bloqueado_ate'] ??= 0;
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agora = time();

    if ($agora < $_SESSION['bloqueado_ate']) {
        $restante = $_SESSION['bloqueado_ate'] - $agora;
        $mensagem = "Aguarde $restante segundos para tentar novamente.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $dao = new UsuarioDAO(conectar());
        $usuario = $dao->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'email' => $usuario['email'],
                'perfil' => $usuario['perfil'],
            ];
            $_SESSION['tentativas_login'] = 0;
            $_SESSION['bloqueado_ate'] = 0;
            header('Location: relatorios_gerenciais.php');
            exit;
        }

        $_SESSION['tentativas_login']++;

        if ($_SESSION['tentativas_login'] >= 3) {
            $_SESSION['bloqueado_ate'] = time() + 60;
            $_SESSION['tentativas_login'] = 0;
            $mensagem = 'Muitas falhas. Aguarde 60 segundos.';
        } else {
            $mensagem = 'E-mail ou senha incorretos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login seguro</title>
</head>
<body>
    <h1>Entrar no sistema</h1>

    <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></p>

    <form method="POST">
        <label>E-mail:
            <input type="email" name="email" required>
        </label>
        <br>

        <label>Senha:
            <input type="password" name="senha" required>
        </label>
        <br>

        <button type="submit">Entrar</button>
    </form>

    <?php if (time() < $_SESSION['bloqueado_ate']): ?>
        <p>Tempo restante:
            <?= (int) ($_SESSION['bloqueado_ate'] - time()) ?> segundos
        </p>
    <?php endif; ?>
</body>
</html>
