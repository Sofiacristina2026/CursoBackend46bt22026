
<?php
declare(strict_types=1);

// Configura o cookie de sessão antes de iniciar a sessão.
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

// Compara o perfil atual com o nível mínimo exigido.
function verificarPermissao(string $perfilMinimo): void
{
    $niveis = ['OPERADOR' => 1, 'ADMIN' => 2];
    $perfil = $_SESSION['usuario']['perfil'] ?? '';

    if (!isset($niveis[$perfilMinimo], $niveis[$perfil])
        || $niveis[$perfil] < $niveis[$perfilMinimo]) {
        http_response_code(403);
        exit('Acesso negado: você não tem permissão para esta página.');
    }
}

// Exige perfil de administrador para acessar esta página.
verificarPermissao('ADMIN');

echo 'Acesso autorizado ao conteúdo administrativo.';
