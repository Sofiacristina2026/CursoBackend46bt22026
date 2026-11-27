<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Roteador artesanal HTTP.
 * Suporta rotas com parâmetros dinâmicos no formato {param} (ex: /produtos/{id}).
 */
class Router
{
    /** @var array<string, array> */
    private array $rotas = [];

    /** @var callable[] */
    private array $middleware = [];

    public function get(string $caminho, mixed $handler): void
    {
        $this->rotas['GET'][] = ['caminho' => $caminho, 'handler' => $handler];
    }

    public function post(string $caminho, mixed $handler): void
    {
        $this->rotas['POST'][] = ['caminho' => $caminho, 'handler' => $handler];
    }

    public function usarMiddleware(callable $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        foreach ($this->middleware as $interceptor) {
            $interceptor($metodo, $uri);
        }

        foreach ($this->rotas[$metodo] ?? [] as $rota) {
            $parametros = [];

            if ($this->combinarRota($rota['caminho'], $uri, $parametros)) {
                $this->executarHandler($rota['handler'], $parametros);
                return;
            }
        }

        http_response_code(404);
        echo 'Rota não encontrada.';
    }

    private function combinarRota(string $caminho, string $uri, array &$parametros): bool
    {
        $regex = preg_replace_callback(
            '/\{([a-zA-Z_]+)\}/',
            fn (array $m): string => '(?P<' . $m[1] . '>[^/]+)',
            $caminho
        );
        $regex = '#^' . $regex . '$#';

        if (!preg_match($regex, $uri, $resultado)) {
            return false;
        }

        foreach ($resultado as $chave => $valor) {
            if (!is_int($chave)) {
                $parametros[$chave] = $valor;
            }
        }

        return true;
    }

    private function executarHandler(mixed $handler, array $parametros): void
    {
        if (is_array($handler)) {
            [$controlador, $metodo] = $handler;
            $reflexao = new \ReflectionMethod($controlador, $metodo);
            $argumentos = $this->converterArgumentos($reflexao, $parametros);
            $controlador->{$metodo}(...$argumentos);
            return;
        }

        if ($handler instanceof \Closure) {
            $handler(...$parametros);
            return;
        }

        throw new \InvalidArgumentException('Handler de rota inválido.');
    }

    private function converterArgumentos(\ReflectionMethod $reflexao, array $parametros): array
    {
        $argumentos = [];

        foreach ($reflexao->getParameters() as $parametroReflexao) {
            $nome = $parametroReflexao->getName();
            $valor = $parametros[$nome] ?? null;
            $tipo = $parametroReflexao->getType();

            if ($tipo !== null && $tipo->getName() === 'int' && is_string($valor)) {
                $valor = (int) $valor;
            }

            $argumentos[] = $valor;
        }

        return $argumentos;
    }
}
