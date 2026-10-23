<?php
declare(strict_types=1);


const CONFIG_PATH = __DIR__ . "/config/database.ini";

require_once __DIR__ . "/src/ConexaoBanco.php"; 

/**
 * Exemplo 4: Controle de Estoque com Transações ACID.
 * Garante consistência atômica nas operações de entrada e saída.
 */

class PecaDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Registra a movimentação de estoque de forma atômica (ACID).
     */
    public function registrarMovimentacao(int $pecaId, int $quantidade, string $tipo): bool {
        try {
            $this->pdo->beginTransaction();
            
            if ($tipo === 'saida') {
                if (!$this->verificarEstoqueSuficiente($pecaId, $quantidade)) {
                    $this->pdo->rollBack();
                    return false;
                }
                $sql = "UPDATE pecas_industriais SET estoque = estoque - :qtd WHERE id = :id";
            } else {
                $sql = "UPDATE pecas_industriais SET estoque = estoque + :qtd WHERE id = :id";
            }

            $stmt = $this->pdo->prepare($sql);
            $sucesso = $stmt->execute([':qtd' => $quantidade, ':id' => $pecaId]);

            if ($sucesso) {
                $this->pdo->commit();
                return true;
            }
            
            $this->pdo->rollBack();
            return false;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    private function verificarEstoqueSuficiente(int $pecaId, int $quantidadeRequerida): bool {
        $stmt = $this->pdo->prepare("SELECT estoque FROM pecas_industriais WHERE id = :id");
        $stmt->execute([':id' => $pecaId]);
        $estoqueAtual = (int) $stmt->fetchColumn();
        return $estoqueAtual >= $quantidadeRequerida;
    }
}