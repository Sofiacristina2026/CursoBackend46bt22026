<?php

declare(strict_types=1);

/**
 * Carrega a seção do arquivo .ini e retorna a conexão PDO correspondente.
 */
function carregarAmbiente(string $ambiente): PDO
{
    $caminhoIni = __DIR__ . '/config/database.ini';
    $config = parse_ini_file($caminhoIni, true);

    if (!isset($config[$ambiente])) {
        throw new InvalidArgumentException("O ambiente '{$ambiente}' não existe no .ini.");
    }

    $env = $config[$ambiente];
    $dsn = sprintf("pgsql:host=%s;port=%s;dbname=%s", $env['db_host'], $env['db_port'], $env['db_name']);

    return new PDO($dsn, $env['db_user'], $env['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

/**
 * Demonstra a alteração dinâmica de ambiente.
 */
function testarAlternancia(): void
{
    try {
        $pdoDev = carregarAmbiente('development');
        $bancoDev = $pdoDev->query("SELECT current_database();")->fetchColumn();
        echo "Conectado ao ambiente [development]: Banco '{$bancoDev}'\n";

        $pdoTest = carregarAmbiente('testing');
        $bancoTest = $pdoTest->query("SELECT current_database();")->fetchColumn();
        echo "Conectado ao ambiente [testing]: Banco '{$bancoTest}'\n";
    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage() . "\n";
    }
}

testarAlternancia();
