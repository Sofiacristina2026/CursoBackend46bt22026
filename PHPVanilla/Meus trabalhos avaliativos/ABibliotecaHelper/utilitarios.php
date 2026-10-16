<?php
declare(strict_types=1);

// 1. Formata um número para moeda brasileira.
function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}


// 2. Remove pontos e traços do documento.
function limparDocumento(string $docSujeira): string
{
    return str_replace(['.', '-'], '', $docSujeira);
}

// 3. Aplica desconto no preço usando referência.
function aplicarDesconto(float &$preco, float $porcentagem): void
{
    $desconto = $preco * ($porcentagem / 100);
    $preco -= $desconto;
}

// 4. Retorna as iniciais do nome completo.
function gerarIniciais(string $nomeCompleto): string
{
    // Separa o nome em palavras.
    $palavras = explode(' ', trim($nomeCompleto));

    // Guarda as iniciais.
    $iniciais = '';

    // Percorre cada palavra do nome.
    foreach ($palavras as $palavra) {
        if ($palavra !== '') {
            $iniciais .= strtoupper(substr($palavra, 0, 1));
        }
    }

    // Retorna as iniciais.
    return $iniciais;
}
