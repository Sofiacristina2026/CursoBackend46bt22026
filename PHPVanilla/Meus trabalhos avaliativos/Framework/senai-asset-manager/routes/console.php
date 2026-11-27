<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Exibe uma frase inspiradora')->hourly();

/**
 * Parte B - Exercicio 2: Comando artisan corporativo php artisan senai:status.
 * Imprime o nome da plataforma, o ambiente ativo e o total de ativos operacionais.
 */
Artisan::command('senai:status', function () {
    // Nome da plataforma (via $this->info, conforme solicitado)
    $this->info('SENAI Asset Manager');

    // Ambiente ativo da aplicacao (APP_ENV)
    $this->line('Ambiente: ' . config('app.env'));

    // Total de ativos operacionais na fabrica (simulacao do estoque de producao)
    $totalOperacionais = 34;
    $this->line("Ativos operacionais: {$totalOperacionais}");
})->purpose('Exibe o status corporativo da plataforma SENAI');
