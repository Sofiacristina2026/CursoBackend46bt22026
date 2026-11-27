<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Csrf — Geração e validação de tokens CSRF para formulários POST.
 *
 * O token é armazenado na sessão e deve ser enviado em cada submissão
 * para impedir ataques de Cross-Site Request Forgery.
 */
class Csrf
{
    private const SESSION_KEY = 'csrf_token';

    /**
     * Gera um novo token CSRF e armazena na sessão.
     */
    public static function gerarToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_KEY] = $token;
        return $token;
    }

    /**
     * Retorna o token CSRF atual da sessão (ou gera um se não houver).
     */
    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY] ?? '')) {
            return self::gerarToken();
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Valida o token enviado contra o armazenado na sessão.
     * Usa hash_equals para evitar timing attacks.
     */
    public static function validar(string $tokenEnviado): bool
    {
        $tokenSessao = $_SESSION[self::SESSION_KEY] ?? '';
        if (empty($tokenSessao) || empty($tokenEnviado)) {
            return false;
        }
        return hash_equals($tokenSessao, $tokenEnviado);
    }

    /**
     * Remove o token CSRF da sessão (útil após logout).
     */
    public static function limpar(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
    }
}
