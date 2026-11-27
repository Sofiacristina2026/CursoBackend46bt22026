<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Roteador — Roteador HTTP com pipeline de segurança (Guards de RBAC).
 *
 * Registra rotas com método, caminho, callback (controlador+ação) e guards.
 * Ao receber uma requisição, executa a pipeline de guards antes de chamar
 * o controlador. Se um guard barrar a requisição (403/redirecionamento), o
 * callback não é executado.
 */
class Roteador
{
    private array $rotas = [];

    /**
     * Registra uma nova rota.
     *
     * @param string   $metodo        GET, POST, PUT, DELETE, etc.
     * @param string   $caminho       Caminho da URL (ex: /login, /dashboard)
     * @param callable $callback      Função controladora a executar
     * @param array    $guards        Instâncias de AuthGuard a executar antes
     */
    public function add(string $metodo, string $caminho, callable $callback, array $guards = []): void
    {
        $this->rotas[] = [
            'metodo'   => strtoupper($metodo),
            'caminho'  => $caminho,
            'callback' => $callback,
            'guards'   => $guards,
        ];
    }

    /**
     * Processa a requisição atual: encontra a rota, executa os guards e chama o callback.
     */
    public function dispatch(string $metodo, string $uri): void
    {
        // Remove query string da URI para comparação de rota
        $caminho = parse_url($uri, PHP_URL_PATH) ?? '/';
        $metodo = strtoupper($metodo);

        foreach ($this->rotas as $rota) {
            if ($rota['metodo'] !== $metodo) {
                continue;
            }

            if ($rota['caminho'] !== $caminho) {
                continue;
            }

            // Executa a pipeline de guards
            foreach ($rota['guards'] as $guard) {
                $guard->exigirAutenticacao();
                $guard->exigirPerfil();
            }

            // Chama o controlador
            ($rota['callback'])();
            return;
        }

        // Nenhuma rota encontrada -> 404
        Logger::aviso('Rota não encontrada (404)', [
            'metodo' => $metodo,
            'uri'    => $uri,
            'ip'     => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);
        http_response_code(404);
        echo '<h1>404 - Página não encontrada</h1>';
    }
}
