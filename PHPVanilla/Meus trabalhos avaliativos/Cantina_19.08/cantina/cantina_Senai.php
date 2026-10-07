<?php 
 
declare(strict_types=1); 
 
//Antes de eu realizar o código eu vou declarar os produtos aos seus respectivos valores e qauntidades. 
 
$produtos = [ 
    1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10], 
    2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8], 
    3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5], 
    4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6] 
]; 
 
//Aí eu coloco que o [] é igual ao pedido para iniciar uma estrutura com o while. Craindo uma váriavel e definindo como um array vazio, como se eu estivesse deixando em branco depois para colocar qual dos produtos a pessoa escolheu 
//Já o = 0 significa que o valor inicial vai começar com zero, ai depois conforme a quantidade de vendas do produto vai aumentar. 
$pedido = []; 
$opcao = 0; 
 
do { 
 
    echo "\n===== CANTINA SENAI =====\n"; 
    echo "1 - Listar produtos\n"; 
    echo "2 - Adicionar produto ao pedido\n"; 
    echo "3 - Exibir resumo do pedido\n"; 
    echo "4 - Finalizar compra\n"; 
    echo "0 - Sair sem finalizar\n"; 
 
    $opcao = (int) readline("Escolha uma opção: "); 
 
    // MATCH eu usei para tentar indentificar qual será a opção  
    $acao = match ($opcao) { 
        1 => "listar", 
        2 => "adicionar", 
        3 => "resumo", 
        4 => "finalizar", 
        0 => "sair", 
        default => "invalida" 
    }; 
      
    //Para listar os produtos eu começo com o if para começar a executar 
    // Eu coloquei também o foreach que era um requisito que eu não tinha feito. Ele serve para mostrar o código praço .. ou seja mostar todos os elementos de uma lista ou array, um por um. 
 
    if ($acao === "listar") { 
 
        echo "\n--- PRODUTOS ---\n"; 
 
        foreach ($produtos as $codigo => $produto) { 
            echo "Código: $codigo | "; 
            echo "Nome: {$produto['nome']} | "; 
            echo "Preço: R$ " . number_format($produto['preco'], 2, ',', '.') . " | "; 
            echo "Estoque: {$produto['estoque']}\n"; 
        } 
 
    //Adicionar o produto 
    //Para quando a pessoa escanear o proruto e perguntar algo referente aquilo teremos diferentes possíveis respostas de acordo com a pergunta. por isso usei o while serve para repetir um bloco de código várias vezes enquanto uma condição específica for verdadeira. Por exemplo se o numero do produto escaneado for =ou menor que 0, não tem no estoque então fala que está inválido. E o while de novo "enquanto" estiver inválido = readline mostra pra gente "Digite de novo" 
    } elseif ($acao === "adicionar") { 
 
        $codigo = (int) readline("Digite o código do produto: "); 
 
        if (!isset($produtos[$codigo])) { 
            echo "Produto não encontrado!\n"; 
            continue; 
        } 
 
        $quantidade = (int) readline("Digite a quantidade: "); 
 
        while ( 
            $quantidade <= 0 || 
            $quantidade > $produtos[$codigo]['estoque'] 
        ) { 
            echo "Quantidade inválida ou maior que o estoque!\n"; 
            $quantidade = (int) readline("Digite novamente: "); 
        } 
 
        $produtos[$codigo]['estoque'] -= $quantidade; 
 
        $pedido[] = [ 
            "nome" => $produtos[$codigo]['nome'], 
            "preco" => $produtos[$codigo]['preco'], 
            "quantidade" => $quantidade 
        ]; 
 
        echo "Produto adicionado ao pedido!\n"; 
 
    //Para contemplar o critério. Quando nenhum produto for encontrado mostrar mensagem ao usuario 
    } elseif ($acao === "resumo") { 
 
        if (empty($pedido)) { 
            echo "Nenhum produto foi adicionado.\n"; 
            continue; 
        } 
 
        $total = 0; 
 
        //O foreach mostra cada produto do pedido e calcula o subtotal. já o  for calcula o total 

        foreach ($pedido as $item) {
            $subtotal = $item['preco'] * $item['quantidade'];

            echo "Produto: {$item['nome']}\n";
            echo "Quantidade: {$item['quantidade']}\n";
            echo "Preço unitário: R$ " . number_format($item['preco'], 2, ',', '.') . "\n";
            echo "Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "\n";
        }
         
        for ($i = 0; $i < count($pedido); $i++) { 
            $total += $pedido[$i]['preco'] * $pedido[$i]['quantidade']; 
        } 
 
        echo "TOTAL: R$ " . number_format($total, 2, ',', '.') . "\n"; 
 
    // Para finalizar o pedido  
    } elseif ($acao === "finalizar") { 
 
        if (empty($pedido)) { 
            echo "O pedido está vazio!\n"; 
            continue; 
        } 
 
        $total = 0; 
 
        for ($i = 0; $i < count($pedido); $i++) { 
            $total += $pedido[$i]['preco'] * $pedido[$i]['quantidade']; 
        } 
 
        echo "\nTotal da compra: R$ "; 
        echo number_format($total, 2, ',', '.') . "\n"; 
 
        echo "1 - Pix (5% de desconto)\n"; 
        echo "2 - Cartão (sem desconto)\n"; 
        echo "3 - Dinheiro (3% de desconto)\n"; 
 
        $pagamento = (int) readline("Forma de pagamento: "); 
 
        $desconto = match ($pagamento) { 
            1 => 0.05, 
            2 => 0, 
            3 => 0.03, 
            default => -1 
        }; 
 
        if ($desconto === -1) { 
            echo "Pagamento inválido!\n"; 
            continue; 
        } 
 
        $valorFinal = $total - ($total * $desconto); 
 
        echo "Valor final: R$ "; 
        echo number_format($valorFinal, 2, ',', '.') . "\n"; 
 
        echo "Compra finalizada com sucesso!\n"; 
 
        break; 
 
    // Caso a pessoa cancele a compra  
    } elseif ($acao === "sair") { 
 
        echo "Compra cancelada\n"; 
 
        break; 
 
    } else {

        echo "Opção inválida!\n";
        continue;

    }

} while ($opcao !== 4 && $opcao !== 0);
