<?php
declare(strict_types=1);
require __DIR__ . '/../layout/header.php';
?>

<?php if ($produto === null): ?>
    <div class="erro">Produto não encontrado.</div>
    <p><a href="/produtos">Voltar ao catálogo</a></p>
<?php else: ?>
    <h1>Detalhe do Produto</h1>
    <table>
        <tr><th>ID</th><td><?= (int) $produto['id'] ?></td></tr>
        <tr><th>Nome</th><td><?= e($produto['nome']) ?></td></tr>
        <tr><th>Categoria</th><td><?= e($produto['categoria']) ?></td></tr>
        <tr><th>Preço</th><td>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></td></tr>
        <tr><th>Estoque</th><td><?= (int) $produto['estoque'] ?></td></tr>
        <tr><th>Descrição</th><td><?= e($produto['descricao'] ?? '') ?></td></tr>
    </table>
    <p><a href="/produtos">Voltar ao catálogo</a></p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
