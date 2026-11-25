namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

class Produto {
    public static function listarTodos(): array {
        $pdo = ConexaoBanco::obterInstancia();
        $stmt = $pdo->query("SELECT * FROM produtos ORDER BY nome ASC");
        return $stmt->fetchAll();
    }
}