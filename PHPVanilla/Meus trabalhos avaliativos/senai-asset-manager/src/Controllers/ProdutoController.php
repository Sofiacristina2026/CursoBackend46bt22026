<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\AuthGuard;
use App\Core\Csrf;
use App\Core\Logger;
use App\Models\Produto;

/**
 * ProdutoController — Catálogo de produtos/insumos.
 *
 * Acessível a gestor, almoxarife e admin.
 */
class ProdutoController extends Controller
{
    /** Lista o catálogo de produtos (GET /produtos) */
    public function index(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        $produtos = Produto::listar();

        $dados = [
            'csrf_token' => Csrf::token(),
            'usuario'    => AuthGuard::usuarioLogado(),
            'produtos'   => $produtos,
        ];

        Logger::info('Visualização do catálogo de produtos', [
            'usuario_id' => AuthGuard::usuarioLogado()['id'] ?? null,
            'total'      => count($produtos),
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        echo $this->render('produtos/index', $dados);
    }
}
