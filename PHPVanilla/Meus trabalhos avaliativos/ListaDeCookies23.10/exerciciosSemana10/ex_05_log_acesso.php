<?php
declare(strict_types=1);

require_once __DIR__ . '/../conexao.php';

// Inicia a sessão com configurações seguras.
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax',
    'path' => '/',
]);

session_start();

// Permite acesso somente ao administrador.
if (($_SESSION['usuario']['perfil'] ?? '') !== 'ADMIN') {
    http_response_code(403);
    exit('Acesso negado! Somente administradores podem visualizar os registros.');
}

// Busca as últimas tentativas de autenticação.
$pdo = conectar();

$sql = 'SELECT id, email, ip, user_agent, sucesso, data_hora
        FROM auditoria_logins
        ORDER BY data_hora DESC
        LIMIT 50';

$registros = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Auditoria de acessos</title>
</head>
<body>

    <h1>Últimas tentativas de login</h1>

    <table border="1">
        <tr>
            <th>E-mail</th>
            <th>IP</th>
            <th>Navegador</th>
            <th>Resultado</th>
            <th>Data e hora</th>
        </tr>

        <?php foreach ($registros as $registro): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($registro['email'], ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars((string) $registro['ip'], ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars((string) $registro['user_agent'], ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= $registro['sucesso'] ? 'Sucesso' : 'Falha' ?>
                </td>

                <td>
                    <?= htmlspecialchars($registro['data_hora'], ENT_QUOTES, 'UTF-8') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
