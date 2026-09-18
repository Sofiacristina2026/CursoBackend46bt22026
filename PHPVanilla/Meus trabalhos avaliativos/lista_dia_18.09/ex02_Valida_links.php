<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$nome = $_POST['nome'] ?? '';
$url = $_POST['url'] ?? '';
$erros = [];
$linkValido = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($nome);
    $url = trim($url);

    if ($nome === '') {
        $erros[] = 'Informe seu nome.';
    }

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $erros[] = 'Informe uma URL válida.';
    } elseif (
        !str_starts_with($url, 'http://') &&
        !str_starts_with($url, 'https://')
    ) {
        $erros[] = 'A URL deve utilizar HTTP ou HTTPS.';
    } else {
        $linkValido = $url;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Validador de Links</title>
</head>
<body>

<h1>Meu Portfólio</h1>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= e($nome) ?>">

    <br><br>

    <label>Link:</label>
    <input type="text" name="url" value="<?= e($url) ?>">

    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<?php foreach ($erros as $erro): ?>

    <p><?= e($erro) ?></p>

<?php endforeach; ?>

<?php if ($linkValido !== ''): ?>

    <p>Colaborador: <?= e($nome) ?></p>

    <a href="<?= e($linkValido) ?>" target="_blank">
        Visitar Portfólio
    </a>

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