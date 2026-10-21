<?php
declare(strict_types=1);

/**
 * Exemplo 1: Gerenciador de Ferramentas CLI com Prepared Statements.
 * Permite cadastrar e listar ferramentas pelo terminal.
 */

// Conecta ao banco de dados PostgreSQL.
$host = 'localhost';
$banco = 'operacao_crud';
$usuario = 'postgres';
$senha = 'aluno01';

$dsn = "pgsql:host=$host;port=5432;dbname=$banco";

$pdo = new PDO($dsn, $usuario, $senha, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

// Cria a tabela de ferramentas caso ela não exista.
$pdo->exec("
    CREATE TABLE IF NOT EXISTS ferramentas (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        sku VARCHAR(50) NOT NULL
    )
");

/**
 * Cadastra uma ferramenta usando Prepared Statement.
 */
function cadastrarFerramenta(
    PDO $pdo,
    string $nome,
    string $sku
): bool {
    $sql = "INSERT INTO ferramentas (nome, sku)
            VALUES (:nome, :sku)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':nome' => $nome,
        ':sku' => $sku
    ]);
}

/**
 * Lista as ferramentas cadastradas.
 */
function listarFerramentas(PDO $pdo): array
{
    $sql = "SELECT id, nome, sku
            FROM ferramentas
            ORDER BY id";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

// Exibe o resultado no terminal.
echo "=== GERENCIADOR DE FERRAMENTAS CLI ===\n";

cadastrarFerramenta($pdo, 'Chave de Fenda', 'SKU-001');
cadastrarFerramenta($pdo, 'Martelo de Borracha', 'SKU-002');

echo "\nListando ferramentas cadastradas:\n";

foreach (listarFerramentas($pdo) as $ferramenta) {
    echo "- ID: {$ferramenta['id']} | ";
    echo "Nome: {$ferramenta['nome']} | ";
    echo "SKU: {$ferramenta['sku']}\n";
}
