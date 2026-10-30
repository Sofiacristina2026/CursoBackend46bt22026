<?php
declare(strict_types=1);

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../UsuarioDAO.php';

// Registra cada tentativa de autenticação no banco.
function registrarAcesso(PDO $pdo, string $email, bool $sucesso): void
{
    $sql = 'INSERT INTO auditoria_logins
            (email, ip, user_agent, sucesso)
            VALUES (:email, :ip, :agente, :sucesso)';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
        'agente' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        'sucesso' => $sucesso,
    ]);

    $_SESSION['ultimo_acesso'] = time();
}

// Inicializa as variáveis de controle.
$_SESSION['tentativas_login'] ??= 0;
$_SESSION['bloqueado_ate'] ??= 0;

$mensagem = '';
$pdo = conectar();
$restante = max(0, $_SESSION['bloqueado_ate'] - time());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agora = time();

    if ($agora < $_SESSION['bloqueado_ate']) {
        $mensagem = 'Aguarde o término do bloqueio.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        $dao = new UsuarioDAO($pdo);
        $usuario = $dao->buscarPorEmail($email);

        $sucesso = $usuario !== null
            && isset($usuario['senha_hash'])
            && password_verify($senha, $usuario['senha_hash']);

        registrarAcesso($pdo, $email, $sucesso);

        if ($sucesso) {
            // Renova o identificador da sessão após o login.
            session_regenerate_id(true);

            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'email' => $usuario['email'],
                'perfil' => $usuario['perfil'],
            ];

            $_SESSION['tentativas_login'] = 0;
            $_SESSION['bloqueado_ate'] = 0;

            header('Location: ../relatorios_gerenciais.php');
            exit;
        }

        $_SESSION['tentativas_login']++;

        if ($_SESSION['tentativas_login'] >= 3) {
            $_SESSION['bloqueado_ate'] = time() + 60;
            $_SESSION['tentativas_login'] = 0;
            $mensagem = 'Muitas tentativas! Aguarde 60 segundos.';
        } else {
            $mensagem = 'E-mail ou senha incorretos.';
        }
    }

    $restante = max(0, $_SESSION['bloqueado_ate'] - time());
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

    <?php if ($restante > 0): ?>
        <p>
            Tempo restante:
            <strong id="contador"><?= $restante ?></strong> segundos
        </p>
    <?php endif; ?>

    <form method="POST">
        <label>
            E-mail:
            <input type="email" name="email" required>
        </label>

        <br>

        <label>
            Senha:
            <input type="password" name="senha" required>
        </label>

        <br>

        <button type="submit" <?= $restante > 0 ? 'disabled' : '' ?>>
            Entrar
        </button>
    </form>

    <script>
        // Atualiza o contador de bloqueio automaticamente.
        let contador = document.getElementById('contador');

        if (contador) {
            let tempo = Number(contador.textContent);
            let botao = document.querySelector('button');

            let intervalo = setInterval(() => {
                tempo--;
                contador.textContent = tempo;

                if (tempo <= 0) {
                    clearInterval(intervalo);
                    botao.disabled = false;
                    location.reload();
                }
            }, 1000);
        }
    </script>

</body>
</html>
