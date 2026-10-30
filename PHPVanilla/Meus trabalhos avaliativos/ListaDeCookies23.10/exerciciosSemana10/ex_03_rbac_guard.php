
<?php
declare(strict_types=1);

// Configura os cookies de sessão.
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

// Encerra a sessão após 15 minutos de inatividade.
if (isset($_SESSION['ultimo_acesso'])
    && time() - $_SESSION['ultimo_acesso'] > 900) {
    session_unset();
    session_destroy();
    header('Location: ../login.php?expirada=1');
    exit;
}

$_SESSION['ultimo_acesso'] = time();

// Verifica se o usuário está autenticado.
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

// Compara o perfil com o nível mínimo exigido.
function verificarPermissao(string $perfilMinimo): void
{
    $niveis = ['OPERADOR' => 1, 'ADMIN' => 2];
    $perfil = $_SESSION['usuario']['perfil'] ?? '';

    if (!isset($niveis[$perfilMinimo], $niveis[$perfil])
        || $niveis[$perfil] < $niveis[$perfilMinimo]) {
        http_response_code(403);
        exit('Acesso negado! Você não possui permissão para acessar esta página.');
    }
}
