namespace App\Core;

class Logger {
    private static string $caminhoLog = __DIR__ . '/../../logs/app.log';

    public static function registrar(string $severidade, string $mensagem, array $contexto = []): void {
        $dataHora = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $usuarioId = $_SESSION['usuario_id'] ?? 'ANÔNIMO';
        
        $payloadContexto = json_encode($contexto, JSON_UNESCAPED_UNICODE);
        $linhaLog = "[{$dataHora}] [{$severidade}] [IP: {$ip}] [User: {$usuarioId}] {$mensagem} | Contexto: {$payloadContexto}" . PHP_EOL;

        // Garante a pasta de logs
        if (!is_dir(dirname(self::$caminhoLog))) {
            mkdir(dirname(self::$caminhoLog), 0755, true);
        }

        file_put_contents(self::$caminhoLog, $linhaLog, FILE_APPEND | LOCK_EX);
    }
}