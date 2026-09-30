<?php

declare(strict_types=1);

/**
 * Grava mensagens estruturadas de auditoria no arquivo de log do sistema.
 */
function registrarLog(string $nivel, string $mensagem): void
{
    $niveisValidos = ['INFO', 'WARNING', 'ERROR'];
    $nivel = strtoupper($nivel);

    if (!in_array($nivel, $niveisValidos, true)) {
        throw new InvalidArgumentException("Nível de log inválido: {$nivel}");
    }

    $diretorioLog = __DIR__ . '/logs';
    if (!is_dir($diretorioLog)) {
        mkdir($diretorioLog, 0755, true);
    }

    $dataHora = date('Y-m-d H:i:s');
    $linhaLog = sprintf("[%s] [%s] %s" . PHP_EOL, $dataHora, $nivel, $mensagem);

    file_put_contents($diretorioLog . '/sistema.log', $linhaLog, FILE_APPEND);
}

/**
 * Simula operações para alimentar o logger com sucesso e erro.
 */
function executarSimulacaoLogs(): void
{
    $caminhoIni = __DIR__ . '/config/database.ini';

    // 1. Simulação de Sucesso
    try {
        $config = parse_ini_file($caminhoIni, true)['development'];
        $dsn = "pgsql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']}";
        new PDO($dsn, $config['db_user'], $config['db_pass']);

        registrarLog('INFO', 'Conexão com o banco de dados realizada com sucesso.');
        echo "Log de [INFO] gravado com sucesso.\n";
    } catch (PDOException $e) {
        registrarLog('ERROR', 'Falha ao conectar: ' . $e->getMessage());
    }

    // 2. Simulação de Falha
    try {
        $dsnInvalido = "pgsql:host=127.0.0.1;port=5432;dbname=banco_inexistente";
        new PDO($dsnInvalido, 'usuario_errado', 'senha_errada');
    } catch (PDOException $e) {
        registrarLog('ERROR', 'Erro ao conectar ao banco inexistente: ' . $e->getMessage());
        echo "Log de [ERROR] gravado com sucesso.\n";
    }
}

executarSimulacaoLogs();

