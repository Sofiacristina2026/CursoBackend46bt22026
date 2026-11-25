namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

class Usuario {
    public static function buscarPorEmail(string $email): ?array {
        $pdo = ConexaoBanco::obterInstancia();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }
}