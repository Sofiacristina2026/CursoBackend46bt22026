<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

/**
 * Valida empiricamente a identidade de memória entre duas chamadas Singleton.
 */
function provarSingleton(): void
{
    $caminhoIni = __DIR__ . '/config/database.ini';

    // Obtém a conexão duas vezes em variáveis separadas
    $conexao1 = ConexaoBanco::obterConexao($caminhoIni, 'development');
    $conexao2 = ConexaoBanco::obterConexao($caminhoIni, 'development');

    // Recupera os identificadores internos do PHP para cada objeto
    $id1 = spl_object_id($conexao1);
    $id2 = spl_object_id($conexao2);

    echo "SPL Object ID de \$conexao1: {$id1}\n";
    echo "SPL Object ID de \$conexao2: {$id2}\n\n";

    // Validação de identidade estrita (===)
    if ($conexao1 === $conexao2) {
        echo "[PROVADO] Ambas as variáveis referenciam o MESMO endereço de memória.\n";
    } else {
        echo "[FALHA] Foram criadas conexões distintas.\n";
    }
}

provarSingleton();
