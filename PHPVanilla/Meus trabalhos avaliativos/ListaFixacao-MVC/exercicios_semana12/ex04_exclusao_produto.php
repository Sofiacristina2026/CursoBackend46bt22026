<?php

declare(strict_types=1);

// Exercício 4 - Operação de exclusão segura: POST /produtos/excluir.

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Controllers\ProdutoController;
use App\Models\Produto;

Produto::inicializarBanco();

$_SERVER['REQUEST_URI'] = '/produtos';
$_SERVER['REQUEST_METHOD'] = 'GET';

$router = new Router();
$controller = new ProdutoController();

$router->get('/produtos', [$controller, 'listar']);
$router->post('/produtos/excluir', [$controller, 'excluir']);

$router->dispatch();
