<?php

declare(strict_types=1);

use App\Http\Controllers\AtivoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Parte B - Exercicio 1: Rota de telemetria com detalhamento de setores fabris.
 * Nome da rota: ativos.setores
 */
Route::get('/setores', [AtivoController::class, 'setores'])->name('ativos.setores');

/**
 * Parte B - Exercicio 3: Rota com parametro dinamico de identificacao de ativo.
 * Validacao do formato PAT-001 feita dentro do metodo detalhar().
 */
Route::get('/ativos/{codigo}', [AtivoController::class, 'detalhar']);

/**
 * Parte B - Exercicio 5: Endpoint leve de verificacao de saude e uptime.
 */
Route::get('/healthz', [AtivoController::class, 'saude']);
