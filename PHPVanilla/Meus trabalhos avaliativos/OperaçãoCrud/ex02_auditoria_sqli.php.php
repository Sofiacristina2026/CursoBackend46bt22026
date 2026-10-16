<?php
declare(strict_types=1);

/**
 * Exemplo 2: Auditoria de SQL Injection.
 * Demonstra a diferença crítica entre concatenação direta e o uso de Prepared Statements.
 */

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE usuarios (id INTEGER, nome TEXT);");
$pdo->exec("INSERT INTO usuarios VALUES (1, 'Admin'), (2, 'Operador');");

/**
 * Abordagem VULNERÁVEL: Concatenação direta de strings na query.
 * NUNCA utilize este padrão em produção.
 */
function buscarVulneravel(PDO $pdo, string $termo): void {
    echo "[VULNERÁVEL] Executando busca com concatenação...\n";
    // Perigo: A string maliciosa altera a lógica estrutural da query SQL
    $sql = "SELECT * FROM usuarios WHERE nome = '" . $termo . "'";
    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($resultados as $row) {
        echo "-> Encontrado ID: {$row['id']} | Nome: {$row['nome']}\n";
    }
}

/**
 * Abordagem PROTEGIDA: Utiliza Prepared Statements com marcadores nomeados.
 */
function buscarProtegido(PDO $pdo, string $termo): void {
    echo "[PROTEGIDO] Executando busca com Prepared Statement...\n";
    $sql = "SELECT * FROM usuarios WHERE nome = :termo";
    $stmt = $pdo->prepare($sql);
    // O banco trata o valor estritamente como dado, neutralizando o ataque
    $stmt->execute([':termo' => $termo]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($resultados)) {
        echo "-> Nenhum registro encontrado para o termo fornecido.\n";
    }
    foreach ($resultados as $row) {
        echo "-> Encontrado ID: {$row['id']} | Nome: {$row['nome']}\n";
    }
}

// Payload de ataque clássico de Injeção SQL
$payloadMalicioso = "' OR '1'='1";

buscarVulneravel($pdo, $payloadMalicioso);
echo "----------------------------------------\n";
buscarProtegido($pdo, $payloadMalicioso);