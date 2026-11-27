<?php
declare(strict_types=1);
require __DIR__ . '/../layout/header.php';
?>

<h1>Produto não encontrado</h1>
<div class="erro">
    O produto com ID <?= e((string) $id) ?> não foi localizado.
</div>
<p><a href="/produtos">Voltar ao catálogo</a></p>

<?php require __DIR__ . '/../layout/footer.php'; ?>
