@extends('layouts.app')

@section('titulo', $titulo)

@section('conteudo')
<div class="card" style="max-width: 650px; margin: 0 auto;">
    <h2>{{ $titulo }}</h2>
    <p style="color: #94a3b8; font-size: 0.88rem;">Detalhes técnicos do equipamento industrial.</p>

    <div style="margin-top: 20px;">
        <p style="margin: 8px 0;"><strong>TAG do Patrimônio:</strong> {{ $equipamento->tag }}</p>
        <p style="margin: 8px 0;"><strong>Nome do Equipamento:</strong> {{ $equipamento->nome }}</p>
        <p style="margin: 8px 0;"><strong>Setor Fabril:</strong> {{ $equipamento->setor }}</p>
        <p style="margin: 8px 0;"><strong>Criticidade:</strong> <x-badge-prioridade :nivel="$equipamento->criticidade" /></p>
        <p style="margin: 8px 0;"><strong>Status Operacional:</strong> <x-badge-status :status="$equipamento->status" /></p>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: space-between;">
        <a href="{{ route('equipamentos.index') }}" class="btn">← Voltar à Lista</a>
        <a href="{{ route('equipamentos.edit', $equipamento) }}" class="btn" style="background: #0284c7;">Editar Equipamento</a>
    </div>
</div>
@endsection
