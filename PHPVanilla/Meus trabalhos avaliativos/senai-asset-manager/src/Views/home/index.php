<?php declare(strict_types=1); ?>
<?php $titulo = 'Painel'; $ativo = 'dashboard'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Painel de Controle</h2>

<p>Bem-vindo(a), <strong><?= htmlspecialchars($usuario['nome'] ?? '', ENT_QUOTES) ?></strong>
   (perfil: <?= htmlspecialchars($usuario['perfil'] ?? '', ENT_QUOTES) ?>).</p>

<div class="grid-2">
    <div class="card">
        <h3>Total de Produtos</h3>
        <div class="numero"><?= (int) $total_produtos ?></div>
    </div>
    <div class="card">
        <h3>Estoque Abaixo do Mínimo</h3>
        <div class="numero" style="color:<?= $estoque_baixo > 0 ? '#c0392b' : '#27ae60' ?>"><?= (int) $estoque_baixo ?></div>
    </div>
</div>

<h2>Últimas Movimentações</h2>

<?php if (empty($movimentacoes)): ?>
    <p>Nenhuma movimentação registrada ainda.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Data/Hora</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Operador</th>
                <th>Perfil</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimentacoes as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['criado_em'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($m['produto_nome'] ?? '', ENT_QUOTES) ?></td>
                    <td>
                        <span class="badge <?= $m['tipo'] === 'entrada' ? 'badge-entrada' : 'badge-saida' ?>">
                            <?= htmlspecialchars(ucfirst($m['tipo'] ?? ''), ENT_QUOTES) ?>
                        </span>
                    </td>
                    <td><?= (int) ($m['quantidade'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($m['usuario_nome'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($m['usuario_perfil'] ?? '', ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
