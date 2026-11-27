<?php declare(strict_types=1); ?>
<?php $titulo = 'Movimentações de Estoque'; $ativo = 'movimentacoes'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Histórico de Movimentações</h2>

<?php if (empty($movimentacoes)): ?>
    <p>Nenhuma movimentação registrada ainda.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data/Hora</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Operador</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimentacoes as $m): ?>
                <tr>
                    <td><?= (int) ($m['id'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($m['criado_em'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($m['produto_nome'] ?? '', ENT_QUOTES) ?></td>
                    <td>
                        <span class="badge <?= $m['tipo'] === 'entrada' ? 'badge-entrada' : 'badge-saida' ?>">
                            <?= htmlspecialchars(ucfirst($m['tipo'] ?? ''), ENT_QUOTES) ?>
                        </span>
                    </td>
                    <td><?= (int) ($m['quantidade'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($m['usuario_nome'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($m['observacao'] ?? '-', ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="/dashboard" class="button" style="display:inline-block; padding:0.6rem 1.2rem; background:#1a5276; color:#fff; border-radius:6px; font-weight:600;">Voltar ao Painel</a></p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
