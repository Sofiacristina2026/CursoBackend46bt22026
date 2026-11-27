<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use App\Core\Logger;

/**
 * Produto — Modelo de domínio para produtos/insumos do estoque.
 *
 * Responsável por listar produtos e consultar saldo físico.
 * A atualização de estoque com bloqueio pessimista é feita em Movimentacao.
 */
class Produto
{
    /**
     * Lista todos os produtos ordenados por nome.
     *
     * @return array Lista de produtos
     */
    public static function listar(): array
    {
        $pdo = ConexaoBanco::getInstance();
        $stmt = $pdo->query(
            'SELECT id, nome, descricao, quantidade, estoque_minimo, criado_em
             FROM produtos
             ORDER BY nome ASC'
        );
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Busca um produto pelo ID.
     *
     * @return array|null Dados do produto ou null
     */
    public static function buscarPorId(int $id): ?array
    {
        $pdo = ConexaoBanco::getInstance();
        $stmt = $pdo->prepare(
            'SELECT id, nome, descricao, quantidade, estoque_minimo, criado_em
             FROM produtos
             WHERE id = :id
             LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $produto = $stmt->fetch();

        return $produto ?: null;
    }
}
