
<?php
declare(strict_types=1);

// Cria a conexão com o PostgreSQL.
function conectar(): PDO
{
    $host = 'localhost';
    $banco = 'exercicios_semana10';
    $usuario = 'postgres';
    $senha = 'SUA_SENHA';

    $dsn = "pgsql:host=$host;dbname=$banco";

    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
