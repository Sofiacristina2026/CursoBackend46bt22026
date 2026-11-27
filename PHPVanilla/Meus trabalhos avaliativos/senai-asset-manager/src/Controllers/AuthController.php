<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\AuthGuard;
use App\Core\Csrf;
use App\Core\Logger;
use App\Models\Usuario;

/**
 * AuthController — Autenticação e sessão de usuários.
 *
 * Responsável por login, logout e regeneração de ID de sessão.
 * Senhas são validadas com password_verify() (hash BCrypt).
 */
class AuthController extends Controller
{
    /** Exibe o formulário de login (GET /login) */
    public function login(): void
    {
        // Usuário já logado vai direto para o painel
        if (AuthGuard::estaAutenticado()) {
            $this->redirecionar('/dashboard');
            return;
        }

        $token = Csrf::gerarToken();
        echo $this->render('auth/login', ['csrf_token' => $token, 'erro' => null]);
    }

    /** Processa o login (POST /login) */
    public function autenticar(): void
    {
        // Valida CSRF em toda submissão POST
        $tokenEnviado = $_POST['csrf_token'] ?? '';
        if (!Csrf::validar($tokenEnviado)) {
            Logger::aviso('CSRF inválido no login', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            http_response_code(403);
            echo '<h1>403 - Token CSRF inválido</h1>';
            echo '<p><a href="/login">Voltar ao login</a></p>';
            return;
        }

        $email    = trim($_POST['email'] ?? '');
        $senha    = $_POST['senha'] ?? '';

        if ($email === '' || $senha === '') {
            $token = Csrf::gerarToken();
            echo $this->render('auth/login', [
                'csrf_token' => $token,
                'erro'       => 'Preencha e-mail e senha.',
            ]);
            return;
        }

        $usuario = Usuario::autenticar($email, $senha);

        if ($usuario === null) {
            $token = Csrf::gerarToken();
            echo $this->render('auth/login', [
                'csrf_token' => $token,
                'erro'       => 'E-mail ou senha inválidos.',
            ]);
            return;
        }

        // Regenera o ID da sessão para evitar fixação de sessão
        session_regenerate_id(true);

        $_SESSION['usuario_id']    = $usuario['id'];
        $_SESSION['usuario_nome']  = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_perfil']= $usuario['perfil'];

        Csrf::gerarToken(); // renova o token após login

        Logger::info('Sessão iniciada e ID regenerado', [
            'usuario_id' => $usuario['id'],
            'perfil'     => $usuario['perfil'],
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        $this->redirecionar('/dashboard');
    }

    /** Processa o logout seguro via POST (POST /logout) */
    public function logout(): void
    {
        // Valida CSRF no logout também
        $tokenEnviado = $_POST['csrf_token'] ?? '';
        if (!Csrf::validar($tokenEnviado)) {
            http_response_code(403);
            echo '<h1>403 - Token CSRF inválido</h1>';
            return;
        }

        $usuarioId = $_SESSION['usuario_id'] ?? null;

        // Destroi a sessão completamente
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();

        Logger::info('Logout realizado', [
            'usuario_id' => $usuarioId,
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        Csrf::limpar();
        $this->redirecionar('/login');
    }
}
