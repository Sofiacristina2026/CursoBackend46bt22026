<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Gerencia a conexão com o banco de dados.
 * As credenciais ficam isoladas em config/database.ini (nunca hardcoded).
 */
class Database
{
    private static ?\PDO $conexao = null;

    private function __construct()
    {
    }

    public static function getConnection(): \PDO
    {
        if (self::$conexao === null) {
            $config = self::lerConfig();
            self::garantirPasta($config['database'] ?? '');
            self::$conexao = new \PDO(
                self::montarDsn($config),
                $config['username'] ?? '',
                $config['password'] ?? ''
            );
            self::$conexao->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
        }

        return self::$conexao;
    }

    private static function lerConfig(): array
    {
        $caminho = __DIR__ . '/../../config/database.ini';
        $ini = parse_ini_file($caminho, true);
        $base = __DIR__ . '/../../';
        $ini['database']['database'] = str_replace(
            '%BASE_DIR%',
            $base,
            $ini['database']['database'] ?? ''
        );

        return $ini['database'] ?? [];
    }

    private static function montarDsn(array $config): string
    {
        $driver = $config['driver'] ?? 'sqlite';
        $database = $config['database'] ?? '';

        if ($driver === 'sqlite') {
            return "sqlite:{$database}";
        }

        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $driver,
            $config['host'] ?? 'localhost',
            $database,
            $config['charset'] ?? 'utf8'
        );
    }

    private static function garantirPasta(string $caminho): void
    {
        $pasta = dirname($caminho);

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }
    }
}
