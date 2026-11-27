<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\AuthGuard;
use App\Core\Csrf;
use App\Core\Logger;
use App\Models\Movimentacao;
use App\Models\Produto;

/**
 * MovimentacaoController — Operações de entrada e saída de estoque.
 *
 * Acessível a gestor, almoxarife e admin.
 * Usa transações ACID e bloqueio pessimista (FOR UPDATE).
 */
class MovimentacaoController extends Controller
{
    /** Lista todas as movimentações (GET /movimentacoes) */
    public function index(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        $movimentacoes = Movimentacao::listar();

        $dados = [
            'csrf_token'   => Csrf::token(),
            'usuario'      => AuthGuard::usuarioLogado(),
            'movimentacoes'=> $movimentacoes,
        ];

        echo $this->render('movimentacoes/index', $dados);
    }

    /** Exibe o formulário de entrada de estoque (GET /movimentacoes/entrada) */
    public function entradaForm(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        $produtos = Produto::listar();

        $dados = [
            'csrf_token' => Csrf::token(),
            'usuario'    => AuthGuard::usuarioLogado(),
            'produtos'   => $produtos,
            'erro'       => null,
        ];

        echo $this->render('movimentacoes/entrada', $dados);
    }

    /** Processa entrada de estoque (POST /movimentacoes/entrada) */
    public function entrada(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        // Valida CSRF
        if (!Csrf::validar($_POST['csrf_token'] ?? '')) {
            Logger::aviso('CSRF inválido na entrada de estoque', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            http_response_code(403);
            echo '<h1>403 - Token CSRF inválido</h1>';
            return;
        }

        $produtoId   = (int) ($_POST['produto_id'] ?? 0);
        $quantidade  = (int) ($_POST['quantidade'] ?? 0);
        $observacao  = trim($_POST['observacao'] ?? '');
        $usuarioId   = (int) ($_SESSION['usuario_id'] ?? 0);

        if ($produtoId <= 0 || $quantidade <= 0) {
            $this->entradaFormComErro('Informe produto e quantidade válidos.');
            return;
        }

        try {
            Movimentacao::registrar($usuarioId, $produtoId, 'entrada', $quantidade, $observacao);
            $this->redirecionar('/movimentacoes?sucesso=entrada');
        } catch (\Throwable $e) {
            Logger::erro('Erro na entrada de estoque: ' . $e->getMessage(), [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            $this->entradaFormComErro($e->getMessage());
        }
    }

    /** Exibe o formulário de saída de estoque (GET /movimentacoes/saida) */
    public function saidaForm(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        $produtos = Produto::listar();

        $dados = [
            'csrf_token' => Csrf::token(),
            'usuario'    => AuthGuard::usuarioLogado(),
            'produtos'   => $produtos,
            'erro'       => null,
        ];

        echo $this->render('movimentacoes/saida', $dados);
    }

    /** Processa saída de estoque (POST /movimentacoes/saida) */
    public function saida(): void
    {
        $guard = new AuthGuard(['gestor', 'almoxarife', 'admin']);
        $guard->exigirAutenticacao();
        $guard->exigirPerfil();

        // Valida CSRF
        if (!Csrf::validar($_POST['csrf_token'] ?? '')) {
            Logger::aviso('CSRF inválido na saída de estoque', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            http_response_code(403);
            echo '<h1>403 - Token CSRF inválido</h1>';
            return;
        }

        $produtoId   = (int) ($_POST['produto_id'] ?? 0);
        $quantidade  = (int) ($_POST['quantidade'] ?? 0);
        $observacao  = trim($_POST['observacao'] ?? '');
        $usuarioId   = (int) ($_SESSION['usuario_id'] ?? 0);

        if ($produtoId <= 0 || $quantidade <= 0) {
            $this->saidaFormComErro('Informe produto e quantidade válidos.');
            return;
        }

        try {
            Movimentacao::registrar($usuarioId, $produtoId, 'saida', $quantidade, $observacao);
            $this->redirecionar('/movimentacoes?sucesso=saida');
        } catch (\Throwable $e) {
            Logger::erro('Erro na saída de estoque: ' . $e->getMessage(), [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            $this->saidaFormComErro($e->getMessage());
        }
    }

    private function entradaFormComErro(string $erro): void
    {
        $produtos = Produto::listar();
        $dados = [
            'csrf_token' => Csrf::token(),
            'usuario'    => AuthGuard::usuarioLogado(),
            'produtos'   => $produtos,
            'erro'       => $erro,
        ];
        echo $this->render('movimentacoes/entrada', $dados);
    }

    private function saidaFormComErro(string $erro): void
    {
        $produtos = Produto::listar();
        $dados = [
            'csrf_token' => Csrf::token(),
            'usuario'    => AuthGuard::usuarioLogado(),
            'produtos'   => $produtos,
            'erro'       => $erro,
        ];
        echo $this->render('movimentacoes/saida', $dados);
    }
}
