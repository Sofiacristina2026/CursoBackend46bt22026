<?php
declare(strict_types=1);


$produtos = [
1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10],
2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8],
3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5],
4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6]
];

$pedido = [];
$opcao = 0;


do{
echo "=====================\n";
echo "Escolha a opção\n";
echo "1 -Listar produtos\n";
echo "2 -Adcionar produtos ao pedido\n";
echo "3 - Exibi resumo do pedido\n";
echo "4 - Finalizar compra\n";
echo "0 - sair\n";
echo "========================\n";
$opcao = readline();

// usar uma estrutura para abrir possibilidades de código

if($opcao==1){
    echo $produtos
} else if($opcao==2){
    echo "Escolha os Produtos";
}else

}while($opcao==0);