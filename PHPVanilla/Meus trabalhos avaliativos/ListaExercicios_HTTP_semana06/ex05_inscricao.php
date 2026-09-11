<?php

declare(strict_types=1);

$nome = $_POST['nome_candidato'] ?? '';
$idade = $_POST['idade'] ?? '';
$curso = $_POST['curso_desejado'] ?? '';

$cursosPermitidos = [
    'Desenvolvimento de Sistemas',
    'Mecatrônica',
    'Redes'
];

$erros = [];
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (strlen(trim($nome)) < 5) {
        $erros['nome'] = 'O nome deve ter pelo menos 5 caracteres.';
    }

    if (!is_numeric($idade) || (int) $idade < 16) {
        $erros['idade'] = 'A idade deve ser maior ou igual a 16 anos.';
    }

    if (!in_array($curso, $cursosPermitidos, true)) {
        $erros['curso'] = 'Escolha um curso válido.';
    }

    if (!isset($_POST['aceite_termos'])) {
        $erros['termos'] = 'Você deve aceitar os termos.';
    }

    if (empty($erros)) {
        $sucesso = true;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição SENAI</title>

    <style>
        .erro {
            color: red;
        }

        .sucesso {
            color: green;
        }
    </style>
</head>

<body>

<h1>Inscrição SENAI</h1>

<form method="POST">

    <label>Nome do candidato:</label>

    <input
        type="text"
        name="nome_candidato"
        value="<?= htmlspecialchars($nome) ?>"
    >

    <?php if (isset($erros['nome'])): ?>
        <p class="erro">
            <?= htmlspecialchars($erros['nome']) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>Idade:</label>

    <input
        type="number"
        name="idade"
        value="<?= htmlspecialchars((string) $idade) ?>"
    >

    <?php if (isset($erros['idade'])): ?>
        <p class="erro">
            <?= htmlspecialchars($erros['idade']) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>Curso desejado:</label>

    <select name="curso_desejado">

        <option value="">Selecione um curso</option>

        <?php foreach ($cursosPermitidos as $cursoPermitido): ?>

            <option
                value="<?= htmlspecialchars($cursoPermitido) ?>"
                <?= $curso === $cursoPermitido ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($cursoPermitido) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <?php if (isset($erros['curso'])): ?>
        <p class="erro">
            <?= htmlspecialchars($erros['curso']) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>

        <input
            type="checkbox"
            name="aceite_termos"
            value="1"
            <?= isset($_POST['aceite_termos']) ? 'checked' : '' ?>
        >

        Aceito os termos

    </label>

    <?php if (isset($erros['termos'])): ?>
        <p class="erro">
            <?= htmlspecialchars($erros['termos']) ?>
        </p>
    <?php endif; ?>

    <br><br>

    <button type="submit">Enviar inscrição</button>

</form>

<?php if ($sucesso): ?>

    <h2 class="sucesso">
        Inscrição realizada com sucesso!
    </h2>

<?php endif; ?>
<style>
    body {
        background-color: pink;
        color: #d63384;
    }

    h1 {
        color: #c2185b;
    }

    h2 {
        color: #ad1457;
    }
</style>

</body>
</html>