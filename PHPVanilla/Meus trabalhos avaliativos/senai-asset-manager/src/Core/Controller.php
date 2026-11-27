<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Controller — Classe abstrata base para todos os controladores.
 *
 * Fornece suporte básico para renderização de views com injeção de dados.
 * Cada controlador concreto estende esta classe.
 */
abstract class Controller
{
    protected array $dados = [];

    /**
     * Renderiza uma view passando os dados para o escopo do template.
     *
     * @param string $nome Caminho relativo da view dentro de src/Views (ex: "home/index")
     * @param array  $dados Variáveis que serão expostas na view
     * @return string Conteúdo HTML da view renderizado
     */
    protected function render(string $nome, array $dados = []): string
    {
        $caminho = __DIR__ . '/../Views/' . $nome . '.php';

        if (!file_exists($caminho)) {
            trigger_error("View não encontrada: {$caminho}", E_USER_WARNING);
            return '<h1>View não encontrada: ' . htmlspecialchars($nome, ENT_QUOTES) . '</h1>';
        }

        // Extrai os dados como variáveis locais dentro do escopo da view
        extract($dados, EXTR_SKIP);

        ob_start();
        include $caminho;
        return ob_get_clean();
    }

    /**
     * Redireciona o navegador para outra URL e encerra a execução.
     */
    protected function redirecionar(string $url): void
    {
        header('Location: ' . $url, true, 302);
        exit;
    }

    /**
     * Envia uma resposta JSON e encerra a execução.
     */
    protected function json(array $dados, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
