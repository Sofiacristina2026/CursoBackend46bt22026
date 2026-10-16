<?php
declare(strict_types=1);

require_once 'conexao.php';
require_once 'PecaDAO.php';

$dao = new PecaDAO($pdo);
$pecasAtivas = $dao->listarPaginado(5, 0);

/**
 * Exemplo 3: Paginação segura de catálogo industrial.
 * Garante que LIMIT e OFFSET sejam vinculados estritamente como inteiros.
 */

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE pecas_industriais (id INTEGER PRIMARY KEY, nome TEXT);");

// Populando dados de exemplo
for ($i = 1; $i <= 12; $i++) {
    $pdo->exec("INSERT INTO pecas_industriais (nome) VALUES ('Peça Industrial #$i');");
}

// Captura o número da página via GET (simulado aqui para fins de execução)
$pagina = (int) ($_GET['p'] ?? 1);
$pagina = max(1, $pagina); // Garante que a página seja no mínimo 1
$limitePorPagina = 5;

// Calcula o deslocamento (offset)
$offset = ($pagina - 1) * $limitePorPagina;

/**
 * Busca paginada utilizando parâmetros vinculados explicitamente como inteiros.
 */
function listarPecasPaginadas(PDO $pdo, int $limite, int $offset): array {
    $sql = "SELECT id, nome FROM pecas_industriais LIMIT :limite OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    
    // Vinculação explícita de tipos inteiros exigida pelo PDO
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$pecas = listarPecasPaginadas($pdo, $limitePorPagina, $offset);

echo "=== CATÁLOGO INDUSTRIAL (Página {$pagina}) ===\n";
foreach ($pecas as $peca) {
    echo "[ID: {$peca['id']}] {$peca['nome']}\n";
}
