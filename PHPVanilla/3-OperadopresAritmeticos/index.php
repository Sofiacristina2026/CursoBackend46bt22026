<?php
// 1. blindagem de operações entra variáveis de tipos diferentes 
declare(strict_types=1);

// Criar um cálculo de Holerite em PHP

// 2. Declaração de constantes 

const TAXA_INSS = 0.08; //8% => 8/100
const DESCONTO_VT = 150.00;

// 3. Declara as variáveis 
// Dados do funcionário 
$nomeFuncionario = "Jão silva";
$salarioBase = 3200.00;
$horasExtras = 10; //10 horas extras no mês

// Declaração de variáveis usando o LowerCamelCase 
// regras -> Primeira palavra toda minúsculae depois as demais palavras ussa -se maiúsculas na primeira letra.
// Exemplo: $hojeEstaUmDiaBonito

//4. Cálculos do Salário
// Valor da hora extra (1.6 da hora normal,)
$valorHoraExtra = ($salarioBase/220) * 1.6;
// -> Crie uma variável $TotalHorasExtras
$totalHoraExtra = $valorHoraExtra * $horasExtras;
// -> Crie uma variável $salarioBruto
$salarioBruto = $salarioBase + $totalHoraExtra;
// -> Criar a variável $descontoInss
$descontoInss = $salarioBruto * TAXA_INSS;
// -> Criar a variável $salarioLiquido
$salarioLiquido = ($salarioBruto - $descontoInss) - DESCONTO_VT ;

?>
?<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holerite <?php echo $nomeFuncionario?></title>
    <!-- folha de estilização CSS -->
    <link rel="stylesheet" href="style.css">
</head>
</head>
<body>
    <h2>Demonstrativo de Pagamento </h2>
    <!-- Saída de Dados Misturando HTML e PHP em uma tabela -->
    <table>
        <tr> 
            <th>Colaborador(a)</th>
            <td><?php echo $nomeFuncionario?></td>
        </tr>
        <tr> 
            <th>Salário Base</th>
            <td><?php echo "R$ " . number_format($salarioBase, 2, ",", ".")?></td>
            <!-- usando uma função chamada number_format (formata a saída de numeros) -->
        </tr>
        <!-- Fazer as demais linhas da tabela utilizando as variáveis criadas -->
        
        <tr>

            <th>Salário Base</th>
            <td>R$ <?php echo number_format($salarioBase, 2, ",", "."); ?></td>
            <!-- usando uma função chamada number_format (formata a saída de números) -->
        </tr>

        <!-- fazer as demais linhas da tabela utilizando as variáveis criadas -->
        <tr>
          <th>Valor Hora Extra </th>
          <td> <?php echo number_format($valorHoraExtra, 2, ",", "."); ?></td>
       </tr>
        <tr>
            <th>Hora Extra</th>
            <td> <?php echo number_format($horasExtras, 2, ",", "."); ?></td>
         </tr>
         <tr>
            <th>Salário Bruto </th>
            <td> <?php echo number_format($salarioBruto, 2, ",", "."); ?></td>
         </tr>
          <tr>
            <th>Desconto INSS </th>
            <td> <?php echo number_format($descontoInss, 2, ",", "."); ?></td>
         </tr>
          <tr>
            <th>Total Salário Liquido </th>
            <td> <?php echo number_format($salarioLiquido, 2, ",", "."); ?></td>
         </tr>
    </table>
</body>
</html>
