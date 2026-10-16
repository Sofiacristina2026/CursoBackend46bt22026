<?php
declare(strict_types=1);

/**
 * Exemplo 1: Gerenciador de Ferramentas CLI com Prepared Statements.
 * Permite interagir via terminal para cadastrar e listar ferramentas de forma segura.
 */

// Inicializa a conexão PDO com banco SQLite em memória para testes
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Criação da tabela de ferramentas
$pdo->exec("CREATE TABLE IF NOT EXISTS ferramentas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    sku TEXT NOT NULL
)");

/**
 * Cadastra uma nova ferramenta utilizando Prepared Statement com parâmetros nomeados.
 */
function cadastrarFerramenta(PDO $pdo, string $nome, string $sku): bool {
    $sql = "INSERT INTO ferramentas (nome, sku) VALUES (:nome, :sku)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':nome' => $nome, ':sku' => $sku]);
}

/**
 * Lista todas as ferramentas ativas no sistema de forma segura.
 */
function listarFerramentas(PDO $pdo): array {
    $sql = "SELECT id, nome, sku FROM ferramentas";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Menu interativo simulado via CLI
// (Em um ambiente real, utilizaria-se readline() em loop)
echo "=== GERENCIADOR DE FERRAMENTAS CLI ===\n";
cadastrarFerramenta($pdo, 'Chave de Fenda', 'SKU-001');
cadastrarFerramenta($pdo, 'Martelo de Borracha', 'SKU-002');

echo "\nListando ferramentas cadastradas:\n";
foreach (listarFerramentas($pdo) as $ferramenta) {
    echo "- ID: {$ferramenta['id']} | Nome: {$ferramenta['nome']} | SKU: {$ferramenta['sku']}\n";
}