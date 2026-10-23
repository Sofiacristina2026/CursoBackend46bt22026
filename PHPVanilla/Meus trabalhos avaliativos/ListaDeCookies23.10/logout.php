
<?php
declare(strict_types=1);

// Inicia a sessão para limpar seus dados.
session_start();

// Apaga os dados guardados na sessão.
$_SESSION = [];

// Expira o cookie de sessão no navegador.
if (ini_get('session.use_cookies')) {
    $opcoes = session_get_cookie_params();

    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $opcoes['path'],
        'domain' => $opcoes['domain'],
        'secure' => $opcoes['secure'],
        'httponly' => $opcoes['httponly'],
        'samesite' => $opcoes['samesite'] ?? 'Lax',
    ]);
}

// Destrói a sessão no servidor.
session_destroy();

header('Location: login.php');
exit;
