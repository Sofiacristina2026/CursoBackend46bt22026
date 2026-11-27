<?php
declare(strict_types=1);

namespace App\Core;

/**
 * ConexaoBanco — Singleton de conexão PDO com PostgreSQL.
 *
 * Garante uma única instância de conexão durante toda a requisição,
 * evitando múltiplas conexões abertas ao banco de dados.
 *
 * As credenciais vêm exclusivamente de variáveis de ambiente (.env),
 * nunca hardcoded no código.
 */
class ConexaoBanco
{
    private static ?\PDO $instancia = null;

    private function __construct()
    {
        // Impede instanciação externa (padrão Singleton)
    }

    private function __clone()
    {
        // Impede clonagem
    }

    public static function getInstance(): \PDO
    {
        if (self::$instancia === null) {
            $host     = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $porta    = $_ENV['DB_PORT'] ?? '5432';
            $banco    = $_ENV['DB_DATABASE'] ?? 'senai_supply';
            $usuario  = $_ENV['DB_USERNAME'] ?? 'postgres';
            $senha    = $_ENV['DB_PASSWORD'] ?? '';

            $dsn = "pgsql:host={$host};port={$porta};dbname={$banco}";

            $opcoes = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false, // Prepared statements reais do PostgreSQL
            ];

            self::$instancia = new \PDO($dsn, $usuario, $senha, $opcoes);
        }

        return self::$instancia;
    }
}
