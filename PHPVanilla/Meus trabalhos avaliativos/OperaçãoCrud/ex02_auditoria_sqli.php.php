<?php

require_once __DIR__ . '/src/ConexaoBanco.php';



try {
    $pdo = new PDO(
        "pgsql:host=$host;port=5432;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}