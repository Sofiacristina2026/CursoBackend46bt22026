<?php
declare(strict_types=1);
require __DIR__ . '/../layout/header.php';
?>

<h1>Catálogo de Produtos</h1>

<form method="GET" action="/produtos">
    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" onchange="this.form.submit()">
        <option value="">Todas</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= e($cat) ?>" <?= ($categoria === $cat) ? 'selected' : '' ?>>
                <?= e($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <a href="/produtos" class="btn">Limpar filtro</a>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= (int) $p['id'] ?></td>
                <td><?= e($p['nome']) ?></td>
                <td><?= e($p['categoria']) ?></td>
                <td>R$ <?= number_format((float) $p['preco'], 2, ',', '.') ?></td>
                <td><?= (int) $p['estoque'] ?></td>
                <td>
                    <a href="/produtos/detalhe/<?= (int) $p['id'] ?>">Detalhe</a> |
                    <form method="POST" action="/produtos/excluir" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                        <button type="submit" class="btn btn-excluir"
                            onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/api/produtos">Ver catálogo em JSON</a></p>

<?php require __DIR__ . '/../layout/footer.php'; ?>
