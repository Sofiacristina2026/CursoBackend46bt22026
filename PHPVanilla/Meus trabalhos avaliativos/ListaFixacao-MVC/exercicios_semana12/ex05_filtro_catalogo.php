<?php

declare(strict_types=1);

// Exercício 5 - Filtro de busca por categoria no catálogo.


require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Controllers\ProdutoController;
use App\Models\Produto;

Produto::inicializarBanco();

// Simula uma requisição filtrando pela categoria "Usinagem".
$_SERVER['REQUEST_URI'] = '/produtos?categoria=Usinagem';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Popula $_GET a partir da query string (como faria um servidor web).
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '', $queryString);
$_GET = array_merge($_GET ?? [], $queryString);

$router = new Router();
$controller = new ProdutoController();

$router->get('/produtos', [$controller, 'listar']);

$router->dispatch();
