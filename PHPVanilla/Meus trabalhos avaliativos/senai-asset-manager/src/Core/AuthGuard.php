<?php
declare(strict_types=1);

namespace App\Core;

/**
 * AuthGuard — Pipeline de autorização RBAC (Role-Based Access Control).
 *
 * Perfis disponíveis:
 *   - admin    : acesso total a todas as rotas
 *   - gestor   : leitura, entradas/saídas, relatórios
 *   - almoxarife: entrada e saída de produtos, leitura de catálogo
 *
 * Barrar acessos indevidos com HTTP 403 Forbidden.
 * Redirecionar anônimos para /login.
 */
class AuthGuard
{
    private array $perfisPermitidos;

    public function __construct(array $perfisPermitidos = [])
    {
        $this->perfisPermitidos = $perfisPermitidos;
    }

    /**
     * Verifica se há um usuário autenticado na sessão.
     */
    public static function estaAutenticado(): bool
    {
        return !empty($_SESSION['usuario_id'] ?? null);
    }

    /**
     * Retorna os dados do usuário logado ou null.
     */
    public static function usuarioLogado(): ?array
    {
        if (!self::estaAutenticado()) {
            return null;
        }

        return [
            'id'       => $_SESSION['usuario_id'] ?? null,
            'nome'     => $_SESSION['usuario_nome'] ?? '',
            'email'    => $_SESSION['usuario_email'] ?? '',
            'perfil'   => $_SESSION['usuario_perfil'] ?? '',
        ];
    }

    /**
     * Retorna o perfil do usuário logado ou string vazia.
     */
    public static function perfilLogado(): string
    {
        return $_SESSION['usuario_perfil'] ?? '';
    }

    /**
     * Exige autenticação. Redireciona anônimos para /login.
     */
    public function exigirAutenticacao(): void
    {
        if (!self::estaAutenticado()) {
            Logger::aviso('Acesso negado: usuário não autenticado', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
                'rota' => $_SERVER['REQUEST_URI'] ?? '',
            ]);
            http_response_code(302);
            header('Location: /login');
            exit;
        }
    }

    /**
     * Exige que o perfil do usuário esteja entre os permitidos.
     * Caso contrário, responde com HTTP 403 Forbidden.
     */
    public function exigirPerfil(): void
    {
        $perfil = self::perfilLogado();

        if (empty($perfil)) {
            $this->exigirAutenticacao();
            return;
        }

        if (!empty($this->perfisPermitidos) && !in_array($perfil, $this->perfisPermitidos, true)) {
            Logger::aviso("Acesso negado (403): perfil '{$perfil}' sem privilégio", [
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
                'perfil'  => $perfil,
                'rota'    => $_SERVER['REQUEST_URI'] ?? '',
                'perfis_esperados' => $this->perfisPermitidos,
            ]);
            http_response_code(403);
            header('Content-Type: text/html; charset=utf-8');
            echo '<h1>403 - Acesso Negado</h1>';
            echo '<p>Seu perfil (' . htmlspecialchars($perfil, ENT_QUOTES) . ') não tem permissão para acessar este recurso.</p>';
            echo '<p><a href="/dashboard">Voltar ao painel</a></p>';
            exit;
        }
    }
}
