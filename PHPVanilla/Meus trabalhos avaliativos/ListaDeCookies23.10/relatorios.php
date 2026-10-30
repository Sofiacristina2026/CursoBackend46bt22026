<?php
declare(strict_types=1);

require_once __DIR__ . '/exercicios_semana10/ex03_rbac_guard.php';

// Exige perfil de administrador.
verificarPermissao('ADMIN');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios Gerenciais</title>
</head>
<body>
    <h1>Relatórios Gerenciais</h1>

    <p>Bem-vindo ao painel administrativo!</p>
    <p>Somente administradores podem visualizar esta página.</p>
</body>
</html>
