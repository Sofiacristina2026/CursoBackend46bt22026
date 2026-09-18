<?php

declare(strict_types=1);

//Função de segurança contra HTML e XSS
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

//Criei um array vazio (minha caixinha onde vou gurdar os recados)
$mensagens = [];

$nome = $_POST['nome'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';
$erros = [];

//O trim() tira espaços desnecessários do começo e do final.
//Aqui a gente conta quantos caracteres o nome tem.Se tiver menos de 3:
//E colocamos uma mensagem dentro de $erros.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($nome);
    $mensagem = trim($mensagem);

    if (mb_strlen($nome) < 3) {
        $erros[] = 'O nome deve ter pelo menos 3 caracteres.';
    }

    if (mb_strlen($mensagem) < 5) {
        $erros[] = 'A mensagem deve ter pelo menos 5 caracteres.';
    }

    if (empty($erros)) {
        $mensagens[] = [
            'nome' => $nome,
            'mensagem' => $mensagem
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mural de Recados</title>
</head>
<body>

<h1>Mural de Recados</h1>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= e($nome) ?>">

    <br><br>

    <label>Mensagem:</label>
    <textarea name="mensagem"><?= e($mensagem) ?></textarea>

    <br><br>

    <button type="submit">Enviar</button>

</form>

<?php if (!empty($erros)): ?>

    <h2>Erros:</h2>

    <?php foreach ($erros as $erro): ?>
        <p><?= e($erro) ?></p>
    <?php endforeach; ?>

<?php endif; ?>

<h2>Recados</h2>

<?php foreach ($mensagens as $item): ?>

    <p>
        <strong><?= e($item['nome']) ?></strong>
    </p>

    <p><?= nl2br(e($item['mensagem'])) ?></p>

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