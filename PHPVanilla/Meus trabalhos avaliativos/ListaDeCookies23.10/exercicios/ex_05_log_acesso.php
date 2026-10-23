
<?php
declare(strict_types=1);

require_once __DIR__ . '/conexao.php';

// Registra os detalhes de cada tentativa de login.
function registrarAcesso(
    PDO $pdo,
    string $email,
    bool $sucesso
): void {
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
}

// Prepara a conexão com o banco de dados.
$pdo = conectar();

// Exibe o painel somente para administradores autenticados.
session_start();

if (($_SESSION['usuario']['perfil'] ?? '') !== 'ADMIN') {
    http_response_code(403);
    exit('Acesso negado. Somente administradores podem ver os registros.');
}

// Busca as tentativas mais recentes.
$sql = 'SELECT email, ip, user_agent, sucesso, data_hora
        FROM auditoria_logins
        ORDER BY data_hora DESC
        LIMIT 50';

$registros = $pdo->query($sql)->fetchAll();
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
                <td><?= htmlspecialchars($registro['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $registro['ip'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $registro['user_agent'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= $registro['sucesso'] ? 'Sucesso' : 'Falha' ?></td>
                <td><?= htmlspecialchars($registro['data_hora'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
