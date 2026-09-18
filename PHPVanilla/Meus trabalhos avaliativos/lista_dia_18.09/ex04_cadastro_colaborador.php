<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function sanitizarTexto(string $dado): string
{
    return strip_tags(trim($dado));
}

function validarColaborador(array $dados): array
{
    $erros = [];

    if ($dados['nome'] === '') {
        $erros[] = 'Nome obrigatório.';
    }

    if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'E-mail inválido.';
    }

    if (filter_var($dados['matricula'], FILTER_VALIDATE_INT) === false) {
        $erros[] = 'Matrícula inválida.';
    }

    if (filter_var($dados['salario'], FILTER_VALIDATE_FLOAT) === false) {
        $erros[] = 'Salário inválido.';
    }

    return $erros;
}

$dados = [
    'nome' => sanitizarTexto($_POST['nome'] ?? ''),
    'email' => sanitizarTexto($_POST['email'] ?? ''),
    'matricula' => sanitizarTexto($_POST['matricula'] ?? ''),
    'salario' => sanitizarTexto($_POST['salario'] ?? '')
];

$erros = [];
$cadastrado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erros = validarColaborador($dados);
    $cadastrado = empty($erros);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h1>Cadastro de Colaborador</h1>

<form method="POST">

    <input name="nome" placeholder="Nome" value="<?= e($dados['nome']) ?>">
    <br><br>

    <input name="email" placeholder="E-mail" value="<?= e($dados['email']) ?>">
    <br><br>

    <input name="matricula" placeholder="Matrícula" value="<?= e($dados['matricula']) ?>">
    <br><br>

    <input name="salario" placeholder="Salário" value="<?= e($dados['salario']) ?>">
    <br><br>

    <button>Cadastrar</button>

</form>

<?php foreach ($erros as $erro): ?>
    <p><?= e($erro) ?></p>
<?php endforeach; ?>

<?php if ($cadastrado): ?>

    <h2>Colaborador cadastrado!</h2>

    <p>Nome: <?= e($dados['nome']) ?></p>
    <p>E-mail: <?= e($dados['email']) ?></p>
    <p>Matrícula: <?= e($dados['matricula']) ?></p>
    <p>Salário: <?= e($dados['salario']) ?></p>

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

