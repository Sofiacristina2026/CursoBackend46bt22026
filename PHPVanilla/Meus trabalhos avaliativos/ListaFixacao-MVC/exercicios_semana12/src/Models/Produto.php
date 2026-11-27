<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Model dos produtos.
 * Toda a consulta SQL reside nesta camada e utiliza prepared statements.
 */
class Produto
{
    public static function buscarTodos(): array
    {
        $conexao = Database::getConnection();
        $stmt = $conexao->query('SELECT * FROM produtos ORDER BY id');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorCategoria(string $categoria): array
    {
        $conexao = Database::getConnection();
        $stmt = $conexao->prepare(
            'SELECT * FROM produtos WHERE categoria = :categoria ORDER BY id'
        );
        $stmt->execute([':categoria' => $categoria]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(int $id): ?array
    {
        $conexao = Database::getConnection();
        $stmt = $conexao->prepare(
            'SELECT * FROM produtos WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $produto === false ? null : $produto;
    }

    public static function excluir(int $id): bool
    {
        $conexao = Database::getConnection();
        $stmt = $conexao->prepare('DELETE FROM produtos WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public static function listarCategorias(): array
    {
        $conexao = Database::getConnection();
        $stmt = $conexao->query(
            'SELECT DISTINCT categoria FROM produtos ORDER BY categoria'
        );

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function inicializarBanco(): void
    {
        $conexao = Database::getConnection();
        $conexao->exec(
            'CREATE TABLE IF NOT EXISTS produtos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                categoria TEXT NOT NULL,
                preco REAL NOT NULL,
                descricao TEXT,
                estoque INTEGER NOT NULL DEFAULT 0,
                criado_em TEXT DEFAULT CURRENT_TIMESTAMP
            )'
        );

        $stmt = $conexao->query('SELECT COUNT(*) AS total FROM produtos');
        $total = (int) $stmt->fetchColumn();

        if ($total === 0) {
            self::semeiarDados($conexao);
        }
    }

    private static function semeiarDados(\PDO $conexao): void
    {
        $produtos = self::dadosSemente();

        foreach ($produtos as $produto) {
            self::inserirProduto($conexao, $produto);
        }
    }

    private static function dadosSemente(): array
    {
        return [
            ['Fresadora CNC', 'Usinagem', 45000.00, 'Fresadora de precisão para usinagem industrial.', 5],
            ['Torno Universal', 'Usinagem', 38000.00, 'Torno para usinagem de peças metálicas.', 3],
            ['Máquina de Solda MIG', 'Soldagem', 2200.00, 'Soldadora MIG para fabricação estrutural.', 10],
            ['Eletrodo de Solda', 'Soldagem', 150.00, 'Eletrodo revestido para soldagem.', 100],
            ['Tinta Epóxi Industrial', 'Pintura', 180.00, 'Tinta epóxi de alta resistência.', 20],
            ['Pistola de Pintura', 'Pintura', 350.00, 'Pistola pneumática para pintura industrial.', 8],
            ['Parafusadeira de Impacto', 'Montagem', 400.00, 'Parafusadeira de impacto para montagem.', 12],
            ['Chave de Fenda Isolada', 'Montagem', 30.00, 'Chave de fenda com haste isolada.', 50],
        ];
    }

    private static function inserirProduto(\PDO $conexao, array $produto): void
    {
        $stmt = $conexao->prepare(
            'INSERT INTO produtos (nome, categoria, preco, descricao, estoque)
             VALUES (:nome, :categoria, :preco, :descricao, :estoque)'
        );
        $stmt->execute([
            ':nome' => $produto[0],
            ':categoria' => $produto[1],
            ':preco' => $produto[2],
            ':descricao' => $produto[3],
            ':estoque' => $produto[4],
        ]);
    }
}
