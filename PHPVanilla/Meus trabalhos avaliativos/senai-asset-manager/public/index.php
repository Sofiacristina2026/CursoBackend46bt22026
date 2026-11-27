<?php
declare(strict_types=1);

/**
 * SENAI Supply — Front Controller (Ponto único de entrada)
 *
 * Todas as requisições HTTP passam por aqui. Nenhum outro arquivo PHP
 * deve ser acessado diretamente pelo navegador.
 */

// Inicia a sessão de forma segura
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    session_start();
}

// Carrega o autoloader do Composer (PSR-4: App\ -> src/)
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Roteador;
use App\Core\Logger;
use App\Core\AuthGuard;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProdutoController;
use App\Controllers\MovimentacaoController;

// Inicializa o serviço de logs (garante pasta logs/ e arquivo app.log)
Logger::init(__DIR__ . '/..');

// Instancia o roteador
$roteador = new Roteador();

$auth      = new AuthController();
$home      = new HomeController();
$produtos  = new ProdutoController();
$movimento = new MovimentacaoController();

// Guards reutilizáveis
$guestOnly   = []; // sem guard (público)
$autenticado = [new AuthGuard()]; // qualquer usuário logado
$estoque     = [new AuthGuard(['gestor', 'almoxarife', 'admin'])]; // RBAC estoque

// Rotas públicas (login)
$roteador->add('GET',  '/login',                        [$auth, 'login'],                        $guestOnly);
$roteador->add('POST', '/login',                        [$auth, 'autenticar'],                   $guestOnly);

// Rotas de sessão
$roteador->add('POST', '/logout',                       [$auth, 'logout'],                       $autenticado);

// Rotas protegidas (RBAC)
$roteador->add('GET',  '/dashboard',                    [$home, 'index'],                        $autenticado);
$roteador->add('GET',  '/produtos',                     [$produtos, 'index'],                    $estoque);
$roteador->add('GET',  '/movimentacoes',                [$movimento, 'index'],                   $estoque);
$roteador->add('GET',  '/movimentacoes/entrada',        [$movimento, 'entradaForm'],             $estoque);
$roteador->add('POST', '/movimentacoes/entrada',        [$movimento, 'entrada'],                 $estoque);
$roteador->add('GET',  '/movimentacoes/saida',          [$movimento, 'saidaForm'],               $estoque);
$roteador->add('POST', '/movimentacoes/saida',          [$movimento, 'saida'],                   $estoque);

// Rota raiz redireciona para login ou dashboard
$roteador->add('GET',  '/', function () use ($auth) {
    if (AuthGuard::estaAutenticado()) {
        header('Location: /dashboard', true, 302);
        exit;
    }
    header('Location: /login', true, 302);
    exit;
}, $guestOnly);

// Log da requisição recebida (auditoria de acesso)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

Logger::info("Requisição recebida: {$metodo} {$uri}", ['ip' => $ip]);

try {
    $roteador->dispatch($metodo, $uri);
} catch (Throwable $e) {
    Logger::erro("Erro não tratado: " . $e->getMessage(), [
        'ip' => $ip,
        'arquivo' => $e->getFile(),
        'linha' => $e->getLine(),
    ]);
    http_response_code(500);
    echo '<h1>Erro interno do servidor</h1>';
    echo '<p>Ocorreu um erro inesperado. O incidente foi registrado em log.</p>';
}
