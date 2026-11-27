<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Logger — Serviço centralizado de logs de auditoria.
 *
 * Grava entradas cronológicas com trava atômica (LOCK_EX) em logs/app.log,
 * fora da pasta pública da web. Cada linha contém:
 *   - data/hora
 *   - severidade (INFO, AVISO, ERRO)
 *   - IP do operador
 *   - mensagem
 *   - contexto estruturado (JSON)
 */
class Logger
{
    private static string $caminhoLog;

    public static function init(string $diretorioRaiz): void
    {
        self::$caminhoLog = $diretorioRaiz . '/logs/app.log';

        // Garante que o diretório de logs exista
        $diretorio = dirname(self::$caminhoLog);
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
    }

    private static function gravar(string $severidade, string $mensagem, array $contexto = []): void
    {
        if (self::$caminhoLog === '') {
            return;
        }

        $dataHora = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
        $contextoJson = json_encode($contexto, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?? '{}';

        $linha = sprintf(
            "[%s] [%s] [IP:%s] %s | Contexto: %s" . PHP_EOL,
            $dataHora,
            $severidade,
            $ip,
            $mensagem,
            $contextoJson
        );

        // Trava atômica (LOCK_EX) para escrita segura em ambientes concorrentes
        $arquivo = fopen(self::$caminhoLog, 'a');
        if ($arquivo === false) {
            return;
        }

        flock($arquivo, LOCK_EX);
        fwrite($arquivo, $linha);
        flock($arquivo, LOCK_UN);
        fclose($arquivo);
    }

    public static function info(string $mensagem, array $contexto = []): void
    {
        self::gravar('INFO', $mensagem, $contexto);
    }

    public static function aviso(string $mensagem, array $contexto = []): void
    {
        self::gravar('AVISO', $mensagem, $contexto);
    }

    public static function erro(string $mensagem, array $contexto = []): void
    {
        self::gravar('ERRO', $mensagem, $contexto);
    }
}
