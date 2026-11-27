<?php

declare(strict_types=1);

// Exercício 2 - Resposta em formato JSON para APIs RESTful.

require __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\Controllers\ProdutoController;
use App\Models\Produto;

Produto::inicializarBanco();

$controller = new ProdutoController();

// Chama o controller que utiliza renderizarJson() da classe base Controller.
// Define Content-Type: application/json e o código de status HTTP.
$controller->apiProdutos();
