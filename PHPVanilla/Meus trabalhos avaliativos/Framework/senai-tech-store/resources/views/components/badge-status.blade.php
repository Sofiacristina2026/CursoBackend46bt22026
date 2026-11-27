@props(['estoque'])

@php
    $config = match(true) {
        $estoque === 0 => ['classe' => 'badge-esgotado', 'label' => 'ESGOTADO'],
        $estoque < 10  => ['classe' => 'badge-critico', 'label' => 'CRÍTICO'],
        default        => ['classe' => 'badge-disponivel', 'label' => 'DISPONÍVEL'],
    };
@endphp

<span class="badge-status {{ $config['classe'] }}">
    {{ $config['label'] }} ({{ $estoque }} un)
</span>
