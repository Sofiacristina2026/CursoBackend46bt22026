<?php declare(strict_types=1); ?>
<?php $titulo = 'Catálogo de Produtos'; $ativo = 'produtos'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Catálogo de Produtos / Insumos</h2>

<?php if (empty($produtos)): ?>
    <p>Nenhum produto cadastrado.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Estoque Mínimo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= (int) ($p['id'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($p['nome'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($p['descricao'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= (int) ($p['quantidade'] ?? 0) ?></td>
                    <td><?= (int) ($p['estoque_minimo'] ?? 0) ?></td>
                    <td>
                        <span class="badge <?= ((int) ($p['quantidade'] ?? 0) <= (int) ($p['estoque_minimo'] ?? 0)) ? 'badge-saida' : 'badge-entrada' ?>">
                            <?= ((int) ($p['quantidade'] ?? 0) <= (int) ($p['estoque_minimo'] ?? 0)) ? 'Abaixo do Mínimo' : 'OK' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="/dashboard" class="button" style="display:inline-block; padding:0.6rem 1.2rem; background:#1a5276; color:#fff; border-radius:6px; font-weight:600;">Voltar ao Painel</a></p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
