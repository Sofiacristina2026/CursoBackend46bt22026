<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

/**
 * Executa o teste comparativo entre conexões diretas e a reutilização via Singleton.
 */
function executarBenchmark(): array
{
    $caminhoIni = __DIR__ . '/config/database.ini';
    $config = parse_ini_file($caminhoIni, true)['development'];
    $dsn = "pgsql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']}";

    // 1. Teste SEM Singleton (50 conexões novas)
    $inicioSemSingleton = microtime(true);
    $memoriaInicioSem = memory_get_usage();

    for ($i = 0; $i < 50; $i++) {
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    $tempoSem = microtime(true) - $inicioSemSingleton;
    $memoriaSem = memory_get_usage() - $memoriaInicioSem;

    // 2. Teste COM Singleton (50 reusos)
    $inicioComSingleton = microtime(true);
    $memoriaInicioCom = memory_get_usage();

    for ($i = 0; $i < 50; $i++) {
        $pdo = ConexaoBanco::obterConexao($caminhoIni, 'development');
    }

    $tempoCom = microtime(true) - $inicioComSingleton;
    $memoriaCom = memory_get_usage() - $memoriaInicioCom;

    return [
        'sem' => ['tempo' => $tempoSem, 'memoria' => $memoriaSem],
        'com' => ['tempo' => $tempoCom, 'memoria' => $memoriaCom]
    ];
}

$res = executarBenchmark();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Benchmark de Conexões PDO</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 600px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .destaque { font-weight: bold; color: green; }
    </style>
</head>
<body>
    <h2>Resultado do Benchmark: 50 Conexões</h2>
    <table>
        <thead>
            <tr>
                <th>Estratégia</th>
                <th>Tempo Total (s)</th>
                <th>Consumo de Memória</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Novas Instâncias (Sem Singleton)</td>
                <td><?= number_format($res['sem']['tempo'], 6) ?>s</td>
                <td><?= number_format($res['sem']['memoria'] / 1024, 2) ?> KB</td>
            </tr>
            <tr class="destaque">
                <td>Reutilização (Com Singleton)</td>
                <td><?= number_format($res['com']['tempo'], 6) ?>s</td>
                <td><?= number_format($res['com']['memoria'] / 1024, 2) ?> KB</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
