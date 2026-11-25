<?php
namespace App\Core;

abstract class Controller {
    protected function renderizar(string $view, array $dados = []): void {
        extract($dados);
        $arquivoView = __DIR__ . "/../Views/{$view}.php";
        
        if (file_exists($arquivoView)) {
            require_once __DIR__ . "/../Views/layout/header.php";
            require_once $arquivoView;
            require_once __DIR__ . "/../Views/layout/footer.php";
        } else {
            http_response_code(404);
            echo "View {$view} não encontrada.";
        }
    }

    protected function verificarCsrf(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
                http_response_code(403);
                die("Erro de Segurança: Token CSRF inválido.");
            }
        }
    }
}