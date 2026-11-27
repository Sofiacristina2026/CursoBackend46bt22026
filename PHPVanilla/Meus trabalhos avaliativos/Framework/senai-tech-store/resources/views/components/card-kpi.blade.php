@props(['titulo', 'valor', 'cor' => 'azul', 'subtitulo' => ''])

@php
    $classeCor = match($cor) {
        'verde', '#4ade80' => 'kpi-verde',
        'ambar', '#f59e0b' => 'kpi-ambar',
        'vermelho', '#f87171' => 'kpi-vermelho',
        default => '',
    };
@endphp

<div class="kpi-card">
    <span class="kpi-titulo">{{ $titulo }}</span>
    <strong class="kpi-valor {{ $classeCor }}">{{ $valor }}</strong>
    @if(!empty($subtitulo))
        <small class="kpi-subtitulo">{{ $subtitulo }}</small>
    @endif
</div>
