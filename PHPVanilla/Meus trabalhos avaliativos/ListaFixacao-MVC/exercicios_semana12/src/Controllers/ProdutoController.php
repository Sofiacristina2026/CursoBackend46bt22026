<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Produto;

class ProdutoController extends Controller
{
    public function listar(): void
    {
        $categoria = $_GET['categoria'] ?? null;

        if ($categoria !== null && $categoria !== '') {
            $produtos = Produto::buscarPorCategoria($categoria);
        } else {
            $produtos = Produto::buscarTodos();
        }

        $categorias = Produto::listarCategorias();
        $this->renderizar('produtos/listar', [
            'produtos' => $produtos,
            'categoria' => $categoria ?? '',
            'categorias' => $categorias,
        ]);
    }

    public function detalhar(int $id): void
    {
        $produto = Produto::buscarPorId($id);

        if ($produto === null) {
            http_response_code(404);
            $this->renderizar('produtos/nao-encontrado', ['id' => $id]);
            return;
        }

        $this->renderizar('produtos/detalhe', ['produto' => $produto]);
    }

    public function excluir(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id === null || $id === false) {
            http_response_code(400);
            echo 'ID inválido.';
            return;
        }

        if (Produto::excluir($id)) {
            header('Location: /produtos');
            exit;
        }

        http_response_code(500);
        echo 'Não foi possível excluir o produto.';
    }

    public function apiProdutos(): void
    {
        $this->renderizarJson(Produto::buscarTodos());
    }
}
