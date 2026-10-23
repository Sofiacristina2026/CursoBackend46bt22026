<?php
declare(strict_types=1);

require_once __DIR__ . '/src/ConexaoBanco.php';

try {
    $pdo = ConexaoBanco::obterConexao(
        __DIR__ . '/config/database.ini'
    );

    echo "Conexão realizada com sucesso!";

    echo "\nBanco: " . $pdo->query(
        'SELECT current_database()'
    )->fetchColumn();

    echo "\nServidor: " . $pdo->query(
        'SELECT inet_server_addr()'
    )->fetchColumn();

} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
} catch (RuntimeException $e) {
    echo "Erro de configuração: " . $e->getMessage();
}