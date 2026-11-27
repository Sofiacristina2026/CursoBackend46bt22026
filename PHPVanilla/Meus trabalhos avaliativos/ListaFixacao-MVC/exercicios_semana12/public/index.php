<?php

declare(strict_types=1);

use App\Core\Database;
use App\Core\Router;
use App\Controllers\ProdutoController;
use App\Models\Produto;

require __DIR__ . '/../vendor/autoload.php';

// Garante que o banco de dados exista e esteja populado com dados de exemplo.
Produto::inicializarBanco();

$router = new Router();

// Middleware de log de acessos: intercepta TODA requisição antes do despacho.
$router->usarMiddleware(function (string $metodo, string $uri): void {
    $linha = sprintf(
        "[%s] %s %s - IP: %s\n",
        date('d/m/Y H:i:s'),
        $metodo,
        $uri,
        $_SERVER['REMOTE_ADDR'] ?? 'desconhecido'
    );
    $pastaLogs = __DIR__ . '/../logs';
    if (!is_dir($pastaLogs)) {
        mkdir($pastaLogs, 0777, true);
    }
    file_put_contents($pastaLogs . '/acessos.log', $linha, FILE_APPEND | LOCK_EX);
});

$controller = new ProdutoController();

// Rotas da aplicação.
$router->get('/produtos', [$controller, 'listar']);
$router->get('/produtos/detalhe/{id}', [$controller, 'detalhar']);
$router->post('/produtos/excluir', [$controller, 'excluir']);
$router->get('/api/produtos', [$controller, 'apiProdutos']);

$router->dispatch();
