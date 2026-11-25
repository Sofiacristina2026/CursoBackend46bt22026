namespace App\Core;

use PDO;
use PDOException;

class ConexaoBanco {
    private static ?PDO $instancia = null;

    private function __construct() {}

    public static function obterInstancia(): PDO {
        if (self::$instancia === null) {
            $host = 'localhost';
            $db   = 'senai_supply';
            $user = 'postgres';
            $pass = 'postgres';
            $port = '5432';

            try {
                self::$instancia = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }
}