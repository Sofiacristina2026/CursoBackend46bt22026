<?php

declare(strict_types=1);

$produtos = [
    [
        'nome' => 'Notebook Lenovo',
        'categoria' => 'Notebook',
        'preco' => 2500.00
    ],
    [
        'nome' => 'Mouse Gamer',
        'categoria' => 'Acessório',
        'preco' => 120.00
    ],
    [
        'nome' => 'Teclado Mecânico',
        'categoria' => 'Acessório',
        'preco' => 250.00
    ],
    [
        'nome' => 'Notebook Dell',
        'categoria' => 'Notebook',
        'preco' => 3200.00
    ],
    [
        'nome' => 'Monitor LG',
        'categoria' => 'Monitor',
        'preco' => 900.00
    ],
    [
        'nome' => 'Celular Samsung',
        'categoria' => 'Smartphone',
        'preco' => 1800.00
    ]
];

$nomeBusca = $_GET['nome'] ?? '';
$precoMaximo = $_GET['preco_maximo'] ?? '';

$produtosFiltrados = array_filter($produtos, function (array $produto) use ($nomeBusca, $precoMaximo): bool {
    $nomeCorresponde = $nomeBusca === ''
        || stripos($produto['nome'], $nomeBusca) !== false;

    $precoCorresponde = $precoMaximo === ''
        || $produto['preco'] <= (float) $precoMaximo;

    return $nomeCorresponde && $precoCorresponde;
});

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>
<body>

<h1>Buscador de Produtos</h1>

<form method="GET">
    <label>Nome do produto:</label>
    <input type="text" name="nome"
           value="<?= htmlspecialchars($nomeBusca) ?>">
    <style>
    body {
        background-color: pink;
    }
</style>
    <br><br>

    <label>Preço máximo:</label>
    <input type="number" name="preco_maximo"
           step="0.01"
           value="<?= htmlspecialchars($precoMaximo) ?>">

    <br><br>

    <button type="submit">Buscar</button>
</form>

<hr>

<h2>Produtos</h2>

<?php foreach ($produtosFiltrados as $produto): ?>

    <p>
        <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>

        Categoria:
        <?= htmlspecialchars($produto['categoria']) ?><br>

        Preço:
        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
    </p>

<?php endforeach; ?>

<?php if (count($produtosFiltrados) === 0): ?>
    <p>Nenhum produto encontrado.</p>
<?php endif; ?>
<style>
    body {
        background-color: pink;
        color: #d63384;
    }
</style>

</body>
</html>