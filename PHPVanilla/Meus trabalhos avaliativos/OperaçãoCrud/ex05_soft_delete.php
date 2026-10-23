<?php
declare(strict_types=1);

const CONFIG_PATH = __DIR__ . "/config/database.ini";

require_once __DIR__ . "/src/ConexaoBanco.php";

$dao = new PecaDAO($pdo);
$pecasAtivas = $dao->listarPaginado(5, 0);
/**
 * Exemplo 5: Exclusão Lógica (Soft Delete).
 * Mantém os dados no banco para fins de auditoria contábil, ocultando-os nas consultas padrão.
 */

class PecaGerenciadorDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->inicializarTabela();
    }

    private function inicializarTabela(): void {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS pecas_industriais (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT,
            ativo BOOLEAN DEFAULT TRUE
        );");
    }

    /**
     * Realiza a exclusão lógica alterando o status 'ativo' para FALSE.
     */
    public function excluir(int $id): bool {
        $sql = "UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Lista apenas as peças ativas no sistema.
     */
    public function listarTodosAtivos(): array {
        $sql = "SELECT id, nome FROM pecas_industriais WHERE ativo = TRUE";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Demonstração de uso
$pdo = new PDO('sqlite::memory:');
$dao = new PecaGerenciadorDAO($pdo);

// Inserindo dados de teste
$pdo->exec("INSERT INTO pecas_industriais (nome, ativo) VALUES ('Correia Dentada', TRUE);");
echo "Listagem inicial (Ativos):\n";
print_r($dao->listarTodosAtivos());

// Executando Soft Delete na peça ID 1
$dao->excluir(1);
echo "Após Soft Delete (O registro continua fisicamente no banco para auditoria):\n";
print_r($dao->listarTodosAtivos());