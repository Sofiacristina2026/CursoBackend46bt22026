<?php

declare(strict_types=1);

// Exercício 1 - Rota com parâmetro dinâmico

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Controllers\ProdutoController;
use App\Models\Produto;

Produto::inicializarBanco();

// Simula uma requisição GET para /produtos/detalhe/3.
// Altere o valor de REQUEST_URI para testar outro ID (ex: /produtos/detalhe/99 para 404).
$_SERVER['REQUEST_URI'] = '/produtos/detalhe/99';
$_SERVER['REQUEST_METHOD'] = 'GET';

$router = new Router();
$controller = new ProdutoController();

// Rota com parâmetro dinâmico no formato {id}.
$router->get('/produtos/detalhe/{id}', [$controller, 'detalhar']);

$router->dispatch();
