<?php
// Inicialização de Sessão Segura
session_start();
session_regenerate_id(true);

// Carregamento do Autoloader do Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Roteador;

$roteador = new Roteador();

// Registro de Rotas (Definindo URLs, Controllers, Ações e Perfis Autorizados)
$roteador->registrar('GET', '/login', 'AuthController', 'exibirLogin', []);
$roteador->registrar('POST', '/login', 'AuthController', 'processarLogin', []);
$roteador->registrar('POST', '/logout', 'AuthController', 'logout', []);

// Rotas de Home (Logados)
$roteador->registrar('GET', '/', 'HomeController', 'index', []);

// Rotas de Produtos (Admin, Gestor e Almoxarife)
$roteador->registrar('GET', '/produtos', 'ProdutoController', 'index', ['admin', 'gestor', 'almoxarife']);

// Rotas de Movimentação de Estoque (Almoxarife e Admin)
$roteador->registrar('GET', '/movimentacoes/nova', 'MovimentacaoController', 'criar', ['admin', 'almoxarife']);
$roteador->registrar('POST', '/movimentacoes/salvar', 'MovimentacaoController', 'salvar', ['admin', 'almoxarife']);

// Despacha a requisição atual
$roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
public function registrar(string $metodo, string $caminho, string $controller, string $acao, array $perfis = []): void