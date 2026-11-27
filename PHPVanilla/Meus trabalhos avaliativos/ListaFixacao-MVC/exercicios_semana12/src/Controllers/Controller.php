<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Classe base de todos os controllers da aplicação.
 * Centraliza a renderização de views e de respostas JSON.
 */
abstract class Controller
{
    protected function renderizar(string $view, array $dados = []): void
    {
        extract($dados, EXTR_SKIP);
        $caminho = __DIR__ . '/../../views/' . $view . '.php';

        if (!file_exists($caminho)) {
            http_response_code(404);
            echo 'View não encontrada: ' . $view;
            return;
        }

        require $caminho;
    }

    public function renderizarJson(array $dados, int $status = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
