<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

/**
 * Executa o diagnóstico da conexão e imprime o status no terminal.
 */
function testarConexaoCLI(): void
{
    $caminhoIni = __DIR__ . '/config/database.ini';

    try {
        $pdo = ConexaoBanco::obterConexao($caminhoIni, 'development');
        $versao = $pdo->query('SHOW server_version;')->fetchColumn();

        echo "\033[32m[SUCESSO]\033[0m Conexão estabelecida na porta 5432!\n";
        echo "Versão do PostgreSQL: {$versao}\n";
    } catch (PDOException $e) {
        echo "\033[31m[ERRO DE CONEXÃO]\033[0m Não foi possível conectar ao PostgreSQL.\n";
        echo "Detalhe amigável: Verifique se o serviço está ativo na porta 5432.\n";
    } catch (Throwable $e) {
        echo "\033[31m[ERRO]\033[0m " . $e->getMessage() . "\n";
    }
}

// Execução da rotina CLI
testarConexaoCLI();
