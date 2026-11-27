<?php

declare(strict_types=1);

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Middleware\AuditoriaAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

/**
 * Rotas existentes do modulo de Ativos Industriais (Lista anterior).
 */
Route::get('/setores', [AtivoController::class, 'setores'])->name('ativos.setores');
Route::get('/ativos/{codigo}', [AtivoController::class, 'detalhar'])->name('ativos.detalhar');
Route::get('/healthz', [AtivoController::class, 'saude'])->name('ativos.saude');

/**
 * Exercicio 3: Rota com injecao de Request para telemetria de rede (IP e User-Agent).
 */
Route::get('/clientes/telemetria/origem', [ClienteController::class, 'origemRequisicao'])
    ->name('clientes.origem');

/**
 * Filtro por setor industrial com restricao alfanumerica (whereAlphaNumeric).
 */
Route::get('/clientes/setor/{setor?}', [ClienteController::class, 'filtrarPorSetor'])
    ->name('clientes.setor')
    ->whereAlphaNumeric('setor');

/**
 * Exercicio 1: Rota com multiplos parametros e constraints compostas (ID numerico e ano com 4 digitos).
 */
Route::get('/clientes/{cliente}/contratos/{ano}', [ClienteController::class, 'contratosPorAno'])
    ->name('clientes.contratos.ano')
    ->whereNumber('cliente')
    ->where('ano', '[0-9]{4}');

/**
 * Exercicio 5: Rota de alteracao parcial de status via verbo semantico PATCH.
 */
Route::patch('/clientes/{id}/status', [ClienteController::class, 'alterarStatus'])
    ->name('clientes.status')
    ->whereNumber('id');

/**
 * Resource Controller completo de Clientes (7 acoes RESTful) com restricao numerica no ID.
 */
Route::resource('clientes', ClienteController::class)->whereNumber('cliente');

/**
 * Exercicio 2: Resource Controller parcial somente leitura (omissao de criacao, edicao e exclusao).
 */
Route::resource('fornecedores', FornecedorController::class)
    ->parameters(['fornecedores' => 'fornecedor'])
    ->only(['index', 'show'])
    ->whereNumber('fornecedor');

/**
 * Exercicio 4: Agrupamento de rotas administrativas com prefixo /admin, nome admin. e middleware.
 */
Route::prefix('admin')
    ->name('admin.')
    ->middleware([AuditoriaAdminMiddleware::class])
    ->group(function (): void {
        Route::get('/auditoria/clientes', [ClienteController::class, 'auditoriaAtivos'])
            ->name('auditoria.clientes');
    });
