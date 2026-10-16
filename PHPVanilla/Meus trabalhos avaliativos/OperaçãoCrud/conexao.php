<?php
declare(strict_types=1);

/**
 * Arquivo de Conexão Centralizada com o Banco de Dados (PDO).
 * Configura o modo de erro estrito e desativa a emulação de prepared statements.
 */

try {
    // Definição dos parâmetros de conexão (ajuste usuário, senha e banco conforme seu ambiente)
    $dsn = "mysql:host=localhost;dbname=exercicios_semana09;charset=utf8mb4";
    $usuario = "root";
    $senha = "";

    // Instancia o objeto PDO com atributos de segurança e tratamento de erros
    $pdo = new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false, // Força o uso real de Prepared Statements pelo SGBD
    ]);

} catch (PDOException $e) {
    // Interrompe a execução e exibe mensagem amigável em caso de falha na conexão
    exit("Erro crítico na conexão com o banco de dados: " . $e->getMessage());
}