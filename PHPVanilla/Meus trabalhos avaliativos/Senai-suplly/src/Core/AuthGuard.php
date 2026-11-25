namespace App\Core;

class AuthGuard {
    public static function verificar(array $perfisPermitidos = []): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            Logger::registrar('AVISO', 'Acesso negado para usuário não autenticado.');
            header('Location: /login');
            exit;
        }

        if (!empty($perfisPermitidos) && !in_array($_SESSION['usuario_perfil'], $perfisPermitidos)) {
            Logger::registrar('ERRO', 'Tentativa de acesso não autorizado por perfil.', [
                'usuario' => $_SESSION['usuario_email'],
                'perfil' => $_SESSION['usuario_perfil'],
                'requerido' => $perfisPermitidos
            ]);
            http_response_code(403);
            echo "<h1>403 Forbidden</h1><p>Você não tem permissão para acessar este recurso.</p>";
            exit;
        }
    }
}