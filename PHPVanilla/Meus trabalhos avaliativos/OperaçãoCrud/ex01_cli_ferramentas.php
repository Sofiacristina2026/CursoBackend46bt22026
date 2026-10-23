<?php

$host = 'localhost';
$dbname = 'nome_do_banco';
$user = 'postgres';
$password = 'sua_senha';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=5432;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}