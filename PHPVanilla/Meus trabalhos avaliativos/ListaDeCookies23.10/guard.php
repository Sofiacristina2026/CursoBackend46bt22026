
<?php
declare(strict_types=1);

// Inicia uma sessão com configurações seguras.
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

// Encerra a sessão após 15 minutos sem atividade.
$ultimaAtividade = $_SESSION['ultima_atividade'] ?? 0;

if ($ultimaAtividade && time() - $ultimaAtividade > 900) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

// Redireciona usuários que não estão autenticados.
if (!isset($_SESSION['usuario']['id'])) {
    header('Location: login.php');
    exit;
}

// Atualiza o horário da última atividade.
$_SESSION['ultima_atividade'] = time();
