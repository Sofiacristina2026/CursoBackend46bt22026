<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; margin: 0; color: #f8fafc; }
        header { background: #1e293b; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; }
        header h1 { font-size: 1.25rem; color: #38bdf8; margin: 0; }
        nav { display: flex; gap: 16px; align-items: center; }
        nav a { color: #94a3b8; text-decoration: none; font-size: 0.85rem; }
        nav a:hover { color: #38bdf8; }
        .container { max-width: 1080px; margin: 30px auto; padding: 0 20px; }
        .card { background: #1e293b; border-radius: 8px; padding: 25px; border: 1px solid #334155; }
        .topo-acoes { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-novo { background: #0284c7; color: white; padding: 9px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.85rem; }
        .btn-novo:hover { background: #0369a1; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; font-size: 0.9rem; }
        th { color: #94a3b8; background: #0f172a; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; background: #0369a1; color: white; }
        .status-ativo { color: #4ade80; font-weight: bold; }
        .status-suspenso { color: #fbbf24; font-weight: bold; }
        .acoes-col { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn-acao { text-decoration: none; font-size: 0.8rem; font-weight: bold; padding: 4px 8px; border-radius: 4px; color: #38bdf8; }
        .btn-patch { background: #334155; border: 1px solid #475569; color: #fbbf24; cursor: pointer; font-size: 0.8rem; font-weight: bold; padding: 4px 10px; border-radius: 4px; }
        .btn-patch:hover { background: #475569; }
        .btn-delete { background: none; border: none; color: #f87171; cursor: pointer; font-size: 0.8rem; font-weight: bold; padding: 4px 8px; }
        .btn-delete:hover { text-decoration: underline; }
        .alerta-sucesso { background: #14532d; border: 1px solid #16a34a; color: #bbf7d0; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .filtros { display: flex; gap: 10px; margin-bottom: 15px; align-items: center; flex-wrap: wrap; }
        .filtros a { color: #94a3b8; text-decoration: none; font-size: 0.85rem; padding: 4px 10px; border-radius: 4px; background: #0f172a; }
        .filtros a:hover { color: #38bdf8; }
    </style>
</head>
<body>
<header>
    <h1>🏭 SENAI Asset Manager — Gestão de Parceiros</h1>
    <nav>
        <a href="{{ route('ativos.setores') }}">Setores Fabris</a>
        <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
        <a href="{{ route('clientes.origem') }}">Telemetria</a>
        <a href="{{ route('admin.auditoria.clientes') }}">Auditoria Admin</a>
    </nav>
</header>
<div class="container">
    @if(session('sucesso'))
        <div class="alerta-sucesso">✅ {{ session('sucesso') }}</div>
    @endif

    <div class="card">
        <div class="topo-acoes">
            <h2>{{ $titulo }}</h2>
            <a href="{{ route('clientes.create') }}" class="btn-novo">+ Cadastrar Parceiro</a>
        </div>

        <div class="filtros">
            <span>Filtrar Setor:</span>
            <a href="{{ route('clientes.index') }}">Todos</a>
            <a href="{{ route('clientes.setor', 'Autopecas') }}">Autopeças</a>
            <a href="{{ route('clientes.setor', 'Usinagem') }}">Usinagem</a>
            <a href="{{ route('clientes.setor', 'Robotica') }}">Robótica</a>
            <a href="{{ route('clientes.setor', 'Siderurgia') }}">Siderurgia</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Setor</th>
                    <th>Status</th>
                    <th>Ações RESTful</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr>
                        <td>#{{ $cliente->id }}</td>
                        <td><strong>{{ $cliente->razao_social }}</strong></td>
                        <td>{{ $cliente->cnpj }}</td>
                        <td><span class="badge">{{ $cliente->setor }}</span></td>
                        <td>
                            <span class="{{ $cliente->status === 'ATIVO' ? 'status-ativo' : 'status-suspenso' }}">
                                {{ $cliente->status }}
                            </span>
                        </td>
                        <td>
                            <div class="acoes-col">
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn-acao">Ficha</a>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn-acao">Editar</a>

                                {{-- Exercicio 5: Alteracao parcial de status via Method Spoofing (@method('PATCH')) --}}
                                <form action="{{ route('clientes.status', $cliente->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-patch">
                                        {{ $cliente->status === 'ATIVO' ? 'Suspender' : 'Ativar' }}
                                    </button>
                                </form>

                                {{-- Exclusao segura via Method Spoofing (@method('DELETE')) --}}
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Deseja remover este parceiro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#94a3b8;">Nenhum parceiro industrial localizado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
