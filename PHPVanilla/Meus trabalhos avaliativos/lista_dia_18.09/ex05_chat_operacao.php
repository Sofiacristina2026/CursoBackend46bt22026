<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$arquivo = __DIR__ . '/chat.json';

$mensagens = file_exists($arquivo)
    ? json_decode(file_get_contents($arquivo), true) ?? []
    : [];

$nome = $_POST['nome'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($nome);
    $mensagem = trim($mensagem);

    if ($nome === '' || $mensagem === '') {
        $erro = 'Preencha todos os campos.';
    } elseif (mb_strlen($mensagem) > 250) {
        $erro = 'A mensagem deve ter no máximo 250 caracteres.';
    } else {

        $mensagens[] = [
            'nome' => $nome,
            'mensagem' => $mensagem
        ];

        file_put_contents(
            $arquivo,
            json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $nome = '';
        $mensagem = '';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat da Operação</title>
</head>
<body>

<h1>Chat da Operação</h1>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= e($nome) ?>">

    <br><br>

    <label>Mensagem:</label>
    <textarea name="mensagem"><?= e($mensagem) ?></textarea>

    <br><br>

    <button type="submit">Enviar</button>

</form>

<?php if ($erro !== ''): ?>
    <p><?= e($erro) ?></p>
<?php endif; ?>

<h2>Mensagens</h2>

<?php foreach ($mensagens as $item): ?>

    <p>
        <strong><?= e($item['nome']) ?></strong>:
        <?= nl2br(e($item['mensagem'])) ?>
    </p>

<?php endforeach; ?>

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

