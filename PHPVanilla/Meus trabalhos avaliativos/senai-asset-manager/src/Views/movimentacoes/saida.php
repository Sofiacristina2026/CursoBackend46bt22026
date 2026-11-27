<?php declare(strict_types=1); ?>
<?php $titulo = 'Saída de Estoque'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Registrar Saída de Estoque</h2>

<form action="/movimentacoes/saida" method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES) ?>">

    <label for="produto_id">Produto</label>
    <select id="produto_id" name="produto_id" required>
        <option value="">Selecione um produto</option>
        <?php foreach ($produtos ?? [] as $p): ?>
            <option value="<?= (int) ($p['id'] ?? 0) ?>">
                <?= htmlspecialchars($p['nome'] ?? '', ENT_QUOTES) ?> — saldo atual: <?= (int) ($p['quantidade'] ?? 0) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="quantidade">Quantidade a Retirar</label>
    <input type="number" id="quantidade" name="quantidade" min="1" required placeholder="0">

    <label for="observacao">Observação (opcional)</label>
    <textarea id="observacao" name="observacao" rows="3" placeholder="Ex: Consumo na linha de produção"></textarea>

    <button type="submit">Registrar Saída</button>
</form>

<p><a href="/movimentacoes" class="button" style="display:inline-block; padding:0.6rem 1.2rem; background:#7f8c8d; color:#fff; border-radius:6px; font-weight:600;">Voltar à Lista</a></p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
