<?php

declare(strict_types=1);

// Exercício 3 - Middleware de log de acessos no roteador.

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Controllers\ProdutoController;
use App\Models\Produto;

Produto::inicializarBanco();

// Simula uma requisição para gerar o registro de log.
$_SERVER['REQUEST_URI'] = '/produtos?categoria=Usinagem';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '200.135.80.100';

// Popula $_GET a partir da query string (como faria um servidor web).
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '', $queryString);
$_GET = array_merge($_GET ?? [], $queryString);

$router = new Router();
$controller = new ProdutoController();

// Interceptador de requisições no Roteador (antes do despacho).
$router->usarMiddleware(function (string $metodo, string $uri): void {
    $linha = sprintf(
        "[%s] %s %s - IP: %s\n",
        date('d/m/Y H:i:s'),
        $metodo,
        $uri,
        $_SERVER['REMOTE_ADDR'] ?? 'desconhecido'
    );
    $pasta = __DIR__ . '/logs';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }
    file_put_contents($pasta . '/acessos.log', $linha, FILE_APPEND | LOCK_EX);
});

$router->get('/produtos', [$controller, 'listar']);
$router->dispatch();

echo "\nLog gravado em logs/acessos.log\n";
