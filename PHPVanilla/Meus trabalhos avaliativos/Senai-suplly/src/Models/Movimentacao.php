namespace App\Models;

use App\Core\ConexaoBanco;
use App\Core\Logger;
use PDO;
use Exception;

class Movimentacao {
    public static function registrarMovimentacao(int $produtoId, int $usuarioId, string $tipo, int $quantidade): bool {
        $pdo = ConexaoBanco::obterInstancia();

        try {
            // Inicia Transação ACID
            $pdo->beginTransaction();

            // Bloqueio pessimista de linha (FOR UPDATE) para evitar concorrência no estoque
            $stmtProd = $pdo->prepare("SELECT quantidade FROM produtos WHERE id = :id FOR UPDATE");
            $stmtProd->execute(['id' => $produtoId]);
            $produto = $stmtProd->fetch();

            if (!$produto) {
                throw new Exception("Produto não encontrado.");
            }

            $quantidadeAtual = (int)$produto['quantidade'];

            if ($tipo === 'SAIDA') {
                if ($quantidadeAtual < $quantidade) {
                    throw new Exception("Estoque insuficiente. Saldo atual: {$quantidadeAtual}, solicitado: {$quantidade}");
                }
                $novaQuantidade = $quantidadeAtual - $quantidade;
            } else {
                $novaQuantidade = $quantidadeAtual + $quantidade;
            }

            // Atualiza o saldo do produto
            $stmtUp = $pdo->prepare("UPDATE produtos SET quantidade = :qtd, atualizado_em = NOW() WHERE id = :id");
            $stmtUp->execute(['qtd' => $novaQuantidade, 'id' => $produtoId]);

            // Insere o registro na tabela de movimentações
            $stmtMov = $pdo->prepare("INSERT INTO movimentacoes_estoque (produto_id, usuario_id, tipo, quantidade) VALUES (:pid, :uid, :tipo, :qtd)");
            $stmtMov->execute([
                'pid' => $produtoId,
                'uid' => $usuarioId,
                'tipo' => $tipo,
                'qtd' => $quantidade
            ]);

            // Confirma a transação
            $pdo->commit();
            Logger::registrar('INFO', "Movimentação de estoque realizada com sucesso.", [
                'produto_id' => $produtoId,
                'tipo' => $tipo,
                'quantidade' => $quantidade
            ]);
            return true;

        } catch (Exception $e) {
            // Reverte a transação em caso de qualquer falha
            $pdo->rollBack();
            Logger::registrar('ERRO', "Falha transacional no estoque: " . $e->getMessage(), [
                'produto_id' => $produtoId,
                'tipo' => $tipo,
                'quantidade' => $quantidade
            ]);
            return false;
        }
    }
}