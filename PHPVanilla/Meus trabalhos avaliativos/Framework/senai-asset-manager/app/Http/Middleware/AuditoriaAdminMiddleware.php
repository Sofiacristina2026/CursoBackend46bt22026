<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de auditoria para rotas administrativas do grupo /admin.
 */
class AuditoriaAdminMiddleware
{
    /**
     * Registra cabecalho de rastreamento administrativo na resposta HTTP.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $resposta = $next($request);
        $resposta->headers->set('X-Senai-Admin-Audit', 'ativo');

        return $resposta;
    }
}
