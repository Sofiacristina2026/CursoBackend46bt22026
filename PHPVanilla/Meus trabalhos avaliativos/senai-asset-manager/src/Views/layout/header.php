<?php
declare(strict_types=1);

/**
 * Layout — Cabeçalho corporativo compartilhado.
 * Todas as variáveis exibidas são escapadas com htmlspecialchars() (proteção XSS).
 */
$usuario  = $usuario ?? null;
$csrf     = $csrf_token ?? '';
$titulo   = $titulo ?? 'SENAI Supply';
$ativo    = $ativo ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo, ENT_QUOTES) ?> — SENAI Supply</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f8; color: #222; line-height: 1.6; }
        a { color: #1a5276; text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Header / Navbar */
        header { background: #1a5276; color: #fff; padding: 1rem 2rem; }
        header .container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 1.5rem; font-weight: 700; }
        nav a { color: #fff; margin-left: 1.5rem; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 4px; }
        nav a:hover { background: rgba(255,255,255,0.15); text-decoration: none; }
        nav .perfil { font-size: 0.9rem; opacity: 0.9; }

        /* Conteúdo */
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        h2 { color: #1a5276; margin-bottom: 1rem; border-bottom: 2px solid #1a5276; padding-bottom: 0.5rem; }

        /* Mensagens */
        .alerta { background: #fdedec; border-left: 4px solid #e74c3c; padding: 1rem; margin-bottom: 1rem; color: #c0392b; border-radius: 4px; }
        .sucesso { background: #e9f7ef; border-left: 4px solid #27ae60; padding: 1rem; margin-bottom: 1rem; color: #218839; border-radius: 4px; }

        /* Tabelas */
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 2rem; }
        th, td { padding: 0.85rem 1rem; text-align: left; border-bottom: 1px solid #e8e8e8; }
        th { background: #1a5276; color: #fff; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; }
        tr:nth-child(even) { background: #fafafa; }
        tr:hover { background: #f1f5f9; }

        /* Formulários */
        form { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 500px; margin-bottom: 2rem; }
        label { display: block; margin-bottom: 0.4rem; font-weight: 600; color: #1a5276; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            width: 100%; padding: 0.7rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; margin-bottom: 1rem;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        button { background: #1a5276; color: #fff; border: none; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 600; border-radius: 6px; cursor: pointer; width: 100%; }
        button:hover { background: #14486b; }
        button.secondary { background: #7f8c8d; width: auto; }
        button.secondary:hover { background: #6c7a7d; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } header .container { flex-direction: column; gap: 1rem; } nav a { margin: 0.4rem 0; } }

        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
        .badge-entrada { background: #d5f5e3; color: #1e8449; }
        .badge-saida { background: #fadbd8; color: #c0392b; }

        .card { background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; }
        .card h3 { color: #1a5276; margin-bottom: 0.5rem; }
        .card .numero { font-size: 2rem; font-weight: 800; color: #2c3e50; }

        footer { margin-top: 3rem; padding: 1.5rem; text-align: center; color: #7f8c8d; font-size: 0.85rem; border-top: 1px solid #e8e8e8; }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>📦 SENAI Supply</h1>
        <nav>
            <?php if ($usuario): ?>
                <a href="/dashboard" <?= $ativo === 'dashboard' ? 'style="background:rgba(255,255,255,0.15)"' : '' ?>>Painel</a>
                <a href="/produtos" <?= $ativo === 'produtos' ? 'style="background:rgba(255,255,255,0.15)"' : '' ?>>Catálogo</a>
                <a href="/movimentacoes" <?= $ativo === 'movimentacoes' ? 'style="background:rgba(255,255,255,0.15)"' : '' ?>>Movimentações</a>
                <span class="perfil">
                    <?= htmlspecialchars($usuario['nome'] ?? '', ENT_QUOTES) ?>
                    <small> (<?= htmlspecialchars($usuario['perfil'] ?? '', ENT_QUOTES) ?>)</small>
                </span>
                <form action="/logout" method="post" style="display:inline; margin-left:1rem;">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES) ?>">
                    <button type="submit" style="background:transparent; color:#fff; border:none; padding:0.4rem 0.8rem; cursor:pointer; font-weight:600;">Sair</button>
                </form>
            <?php else: ?>
                <a href="/login">Entrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="container">
<?php if (isset($erro) && $erro): ?>
    <div class="alerta"><?= htmlspecialchars($erro, ENT_QUOTES) ?></div>
<?php endif; ?>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'entrada'): ?>
    <div class="sucesso">Entrada de estoque registrada com sucesso!</div>
<?php endif; ?>
<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'saida'): ?>
    <div class="sucesso">Saída de estoque registrada com sucesso!</div>
<?php endif; ?>
