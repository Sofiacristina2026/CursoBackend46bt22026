<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\AuthGuard;
use App\Core\Csrf;
use App\Core\Logger;
use App\Models\Produto;
use App\Models\Movimentacao;

/**
 * HomeController — Painel principal com métricas de estoque.
 *
 * Acessível a qualquer usuário autenticado (gestor, almoxarife, admin).
 */
class HomeController extends Controller
{
    /** Exibe o dashboard com métricas (GET /dashboard) */
    public function index(): void
    {
        $guard = new AuthGuard();
        $guard->exigirAutenticacao();

        $produtos     = Produto::listar();
        $movimentacoes = Movimentacao::listar();

        // Métricas simples
        $totalProdutos      = count($produtos);
        $estoqueBaixo       = 0;
        $valorEstoque       = 0;

        foreach ($produtos as $p) {
            if ((int) $p['quantidade'] <= (int) $p['estoque_minimo']) {
                $estoqueBaixo++;
            }
        }

        // Últimas 10 movimentações já vêm ordenadas do modelo
        $recentes = array_slice($movimentacoes, 0, 10);

        $dados = [
            'csrf_token'   => Csrf::token(),
            'usuario'      => AuthGuard::usuarioLogado(),
            'total_produtos' => $totalProdutos,
            'estoque_baixo'  => $estoqueBaixo,
            'movimentacoes'  => $recentes,
        ];

        Logger::info('Acesso ao painel dashboard', [
            'usuario_id' => AuthGuard::usuarioLogado()['id'] ?? null,
            'perfil'     => AuthGuard::perfilLogado(),
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        echo $this->render('home/index', $dados);
    }
}
