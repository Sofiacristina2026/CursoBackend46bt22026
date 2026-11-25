<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\Usuario;

class AuthController extends Controller {
    
    // Exibe a tela de login
    public function exibirLogin(): void {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /');
            exit;
        }
        
        // Gera um token CSRF seguro para o formulário de login se não existir
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Processa a tentativa de login do usuário
    public function processarLogin(): void {
        $this->verificarCsrf();
        
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        // Busca o usuário no banco de dados pelo e-mail
        $usuario = Usuario::buscarPorEmail($email);

        // Valida se o usuário existe e se a senha está correta (BCRYPT)
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Regenera o ID da sessão por segurança contra Session Fixation
            session_regenerate_id(true);
            
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];

            Logger::registrar('INFO', 'Login efetuado com sucesso.', ['email' => $email]);
            header('Location: /');
            exit;
        }

        // Se falhar, registra no log e exibe mensagem de erro
        Logger::registrar('AVISO', 'Tentativa de login falhou.', ['email' => $email]);
        $erro = "Credenciais inválidas!";
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Realiza o logout seguro do sistema
    public function logout(): void {
        $this->verificarCsrf();
        
        Logger::registrar('INFO', 'Logout efetuado.', ['email' => $_SESSION['usuario_email'] ?? '']);
        
        // Destrói a sessão e limpa os dados
        session_destroy();
        header('Location: /login');
        exit;
    }
}