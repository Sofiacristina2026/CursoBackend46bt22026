<?php

declare(strict_types=1);

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$erro = '';
$sucesso = false;

//Pegar os dados do Formulário
//Verifica se o formulario está emviando os dados como post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erro = 'Digite um e-mail válido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } elseif ($email === 'admin@senai.br' && $senha === 'senhaSegura123') {
        $sucesso = true;
    } else {
        $erro = 'Credenciais inválidas';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Seguro</title>
</head>

<body>

<h1>Login</h1>

<form method="POST">

    <label>E-mail:</label>

    <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($email) ?>"
    >

    <br><br>

    <label>Senha:</label>

    <input
        type="password"
        name="senha"
    >

    <br><br>

    <button type="submit">Entrar</button>

</form>

<?php if ($erro !== ''): ?>

    <p>
        <?= htmlspecialchars($erro) ?>
    </p>

<?php endif; ?>

<?php if ($sucesso): ?>

    <div>
        <h2>Bem-vindo!</h2>
        <p>Login realizado com sucesso.</p>
    </div>

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