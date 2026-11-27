<?php declare(strict_types=1); ?>
<?php $titulo = 'Login'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Entrar no Sistema</h2>

<form action="/login" method="post" style="max-width: 400px;">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES) ?>">

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" required placeholder="seu@email.com">

    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" required placeholder="••••••••">

    <button type="submit">Entrar</button>
</form>

<p style="margin-top:1rem; font-size:0.9rem; color:#7f8c8d;">
    Usuários de teste (cadastre no banco via schema.sql): gestor, almoxarife e admin.
</p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
