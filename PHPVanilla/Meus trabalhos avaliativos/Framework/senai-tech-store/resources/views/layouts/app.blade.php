<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'SENAI Tech Store — Loja de Informática')</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; margin: 0; color: #f8fafc; }
        header { background: #1e293b; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; }
        header h1 { font-size: 1.2rem; color: #38bdf8; margin: 0; }
        .subtitulo-header { font-size: 0.85rem; color: #94a3b8; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .card { background: #1e293b; border-radius: 8px; padding: 25px; border: 1px solid #334155; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.3); }
        .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin: 20px 0; }
        .kpi-card { background: #0f172a; padding: 18px; border-radius: 8px; border: 1px solid #334155; text-align: center; }
        .kpi-titulo { font-size: 0.78rem; color: #94a3b8; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em; }
        .kpi-valor { display: block; font-size: 1.8rem; margin-top: 6px; color: #38bdf8; }
        .kpi-verde { color: #4ade80; }
        .kpi-ambar { color: #f59e0b; }
        .kpi-vermelho { color: #f87171; }
        .kpi-subtitulo { font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block; }
        .badge-status { padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; display: inline-block; }
        .badge-esgotado { background: #7f1d1d; color: #fecaca; }
        .badge-critico { background: #78350f; color: #fef3c7; }
        .badge-disponivel { background: #14532d; color: #bbf7d0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.88rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; }
        th { color: #94a3b8; font-weight: 600; background: #0f172a; }
        .linha-par { background: #1e293b; }
        .linha-impar { background: #0f172a; }
        .preco-destaque { color: #38bdf8; font-weight: bold; }
        .btn { display: inline-block; background: #0284c7; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.85rem; border: none; cursor: pointer; }
        .btn:hover { background: #0369a1; }
        footer { text-align: center; padding: 25px 0; color: #64748b; font-size: 0.8rem; border-top: 1px solid #1e293b; margin-top: 50px; }
        .pagination { display: flex; gap: 8px; margin-top: 25px; justify-content: center; list-style: none; padding: 0; }
        .pagination li a, .pagination li span { background: #1e293b; border: 1px solid #334155; color: #cbd5e1; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .pagination li.active span { background: #0284c7; color: white; border-color: #0284c7; }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <h1>💻 SENAI Tech Store</h1>
        <span class="subtitulo-header">Catálogo Oficial de Hardware e Periféricos</span>
    </header>

    <main class="container">
        @yield('conteudo')
    </main>

    <footer>
        SENAI-SP — Habilitação Técnica em Desenvolvimento de Sistemas | Módulo 3: Migrations, Seeders & Factories
    </footer>
    @stack('scripts')
</body>
</html>
