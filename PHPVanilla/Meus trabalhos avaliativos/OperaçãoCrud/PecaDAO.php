<?php
declare(strict_types=1);

// Importa a conexão PDO centralizada
require_once __DIR__ . '/conexao.php';

/**
 * Classe PecaDAO (Data Access Object)
 * Isola a lógica de persistência e manipulação de dados da tabela pecas_industriais.
 */
class PecaDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Lista as peças de forma paginada utilizando LIMIT e OFFSET como inteiros.
     */
    public function listarPaginado(int $limite, int $offset): array {
        $sql = "SELECT id, nome, estoque, ativo FROM pecas_industriais WHERE ativo = TRUE LIMIT :limite OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        
        // Vinculação explícita de parâmetros inteiros exigida pelo PDO
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Registra movimentação de estoque utilizando transações ACID atômicas.
     */
    public function registrarMovimentacao(int $pecaId, int $quantidade, string $tipo): bool {
        try {
            $this->pdo->beginTransaction();
            
            if ($tipo === 'saida') {
                if (!$this->verificarEstoqueSuficiente($pecaId, $quantidade)) {
                    $this->pdo->rollBack(); // Cancela a transação se o estoque for insuficiente
                    return false;
                }
                $sql = "UPDATE pecas_industriais SET estoque = estoque - :qtd WHERE id = :id";
            } else {
                $sql = "UPDATE pecas_industriais SET estoque = estoque + :qtd WHERE id = :id";
            }

            $stmt = $this->pdo->prepare($sql);
            $sucesso = $stmt->execute([':qtd' => $quantidade, ':id' => $pecaId]);

            if ($sucesso) {
                $this->pdo->commit(); // Efetiva as alterações se tudo ocorrer bem
                return true;
            }
            
            $this->pdo->rollBack();
            return false;
        } catch (Exception $e) {
            $this->pdo->rollBack(); // Desfaz em caso de exceção/erro
            return false;
        }
    }

    /**
     * Verifica se há estoque suficiente antes de realizar uma saída.
     */
    private function verificarEstoqueSuficiente(int $pecaId, int $quantidadeRequerida): bool {
        $stmt = $this->pdo->prepare("SELECT estoque FROM pecas_industriais WHERE id = :id");
        $stmt->execute([':id' => $pecaId]);
        $estoqueAtual = (int) $stmt->fetchColumn();
        return $estoqueAtual >= $quantidadeRequerida;
    }

    /**
     * Realiza a exclusão lógica (Soft Delete) alterando o status 'ativo' para FALSE.
     */
    public function excluir(int $id): bool {
        $sql = "UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}