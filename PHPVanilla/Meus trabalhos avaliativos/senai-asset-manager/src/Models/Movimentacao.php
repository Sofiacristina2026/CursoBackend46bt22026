<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use App\Core\Logger;

/**
 * Movimentacao — Modelo de domínio para entradas e saídas de estoque.
 *
 * Garante integridade ACID nas movimentações físicas:
 *   - beginTransaction() / commit() / rollBack()
 *   - Bloqueio pessimista de linha (SELECT ... FOR UPDATE)
 *   - Validação de saldo físico (impede saídas negativas)
 *   - Associação com o operador autenticado
 */
class Movimentacao
{
    /**
     * Registra uma entrada ou saída de estoque de forma atômica.
     *
     * @param int    $usuarioId    ID do operador autenticado
     * @param int    $produtoId    ID do produto
     * @param string $tipo         'entrada' ou 'saida'
     * @param int    $quantidade   Quantidade movimentada (> 0)
     * @param string|null $observacao Observação opcional
     * @return int ID da movimentação inserida
     * @throws \Exception Se saldo insuficiente ou erro de banco
     */
    public static function registrar(
        int $usuarioId,
        int $produtoId,
        string $tipo,
        int $quantidade,
        ?string $observacao = null
    ): int {
        $pdo = ConexaoBanco::getInstance();

        $pdo->beginTransaction();

        try {
            // Bloqueio pessimista de linha: trava o produto até o commit/rollback
            $stmt = $pdo->prepare(
                'SELECT id, quantidade FROM produtos WHERE id = :id FOR UPDATE'
            );
            $stmt->execute([':id' => $produtoId]);
            $produto = $stmt->fetch();

            if ($produto === false) {
                throw new \Exception("Produto ID {$produtoId} não encontrado.");
            }

            $saldoAtual = (int) $produto['quantidade'];

            // Validação de saldo físico para saídas
            if ($tipo === 'saida' && ($saldoAtual - $quantidade) < 0) {
                $pdo->rollBack();

                Logger::aviso('Saída bloqueada: saldo insuficiente', [
                    'usuario_id'   => $usuarioId,
                    'produto_id'   => $produtoId,
                    'quantidade'   => $quantidade,
                    'saldo_atual'  => $saldoAtual,
                    'ip'           => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
                ]);

                throw new \Exception("Saldo insuficiente. Disponível: {$saldoAtual}, solicitado: {$quantidade}.");
            }

            // Calcula novo saldo
            $novoSaldo = ($tipo === 'entrada')
                ? ($saldoAtual + $quantidade)
                : ($saldoAtual - $quantidade);

            // Atualiza a quantidade do produto
            $stmt = $pdo->prepare(
                'UPDATE produtos SET quantidade = :qtd WHERE id = :id'
            );
            $stmt->execute([':qtd' => $novoSaldo, ':id' => $produtoId]);

            // Registra a movimentação associando o operador
            $stmt = $pdo->prepare(
                'INSERT INTO movimentacoes_estoque
                     (produto_id, usuario_id, tipo, quantidade, observacao, criado_em)
                 VALUES (:produto_id, :usuario_id, :tipo, :quantidade, :observacao, NOW())
                 RETURNING id'
            );
            $stmt->execute([
                ':produto_id'  => $produtoId,
                ':usuario_id'  => $usuarioId,
                ':tipo'        => $tipo,
                ':quantidade'  => $quantidade,
                ':observacao'  => $observacao,
            ]);
            $movimentacaoId = (int) $stmt->fetchColumn();

            $pdo->commit();

            Logger::info("Movimentação de estoque registrada: {$tipo}", [
                'movimentacao_id' => $movimentacaoId,
                'usuario_id'      => $usuarioId,
                'produto_id'      => $produtoId,
                'tipo'            => $tipo,
                'quantidade'      => $quantidade,
                'saldo_anterior'  => $saldoAtual,
                'saldo_novo'      => $novoSaldo,
                'ip'              => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);

            return $movimentacaoId;
        } catch (\Throwable $e) {
            $pdo->rollBack();

            Logger::erro('Falha na transação de movimentação: ' . $e->getMessage(), [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'tipo'       => $tipo,
                'quantidade' => $quantidade,
                'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);

            throw $e;
        }
    }

    /**
     * Lista movimentações de estoque com dados do produto e usuário.
     *
     * @return array Lista de movimentações
     */
    public static function listar(): array
    {
        $pdo = ConexaoBanco::getInstance();
        $stmt = $pdo->query(
            'SELECT m.id, m.tipo, m.quantidade, m.observacao, m.criado_em,
                    p.nome AS produto_nome,
                    u.nome AS usuario_nome, u.perfil AS usuario_perfil
             FROM movimentacoes_estoque m
             JOIN produtos p ON p.id = m.produto_id
             JOIN usuarios u ON u.id = m.usuario_id
             ORDER BY m.criado_em DESC'
        );
        return $stmt->fetchAll() ?: [];
    }
}
