<?php
declare(strict_type=1);

//Função para codificar escape contra XXS 
function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, "UTF-8");
}

$nome = TRIM($_get["nome"] ?? "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Blindada contra XSS</title>
</head>
<body>
    <h1>PErfil do Usuário</h1>

    <!-- Blindando a função e() converte caracteres em entidades inofensivas -->
    <p>Bem-vindo, <?=  e($nome) ?>!</p>

    <form action="seguro.php" method="GET">
        <label for="">Digite seu Nome</label>
        <input type="text" name="nome" value="<?= e($nome) ?>">
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>

