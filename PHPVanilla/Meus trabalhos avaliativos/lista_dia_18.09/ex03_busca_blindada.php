<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$busca = $_GET['q'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>
<body>

<h1>Busca de Produtos</h1>

<form method="GET">

    <input
        type="text"
        name="q"
        value="<?= e($busca) ?>"
    >

    <button type="submit">Buscar</button>

</form>

<?php if ($busca !== ''): ?>

    <p>Você buscou por: <?= e($busca) ?></p>

<?php endif; ?>

<style>
    body {
        background-color: #ffe6f2;
    }
</style>

<style>
    body {
        background-color: #ffe6f2;
    }

    h1, h2 {
        color: #d63384;
    }
</style>

</body>
</html>