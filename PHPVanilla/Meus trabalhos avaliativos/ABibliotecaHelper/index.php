<?php
declare(strict_types=1);

// Importa as funções do arquivo utilitarios.php.
require_once 'utilitarios.php';

// Dados simulados do cliente.
$nomeUsuario = "Sofia Cristina ";
$cpfDigitado = "123.456.789-00";
$valorCompra = 150.00;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste de Funções - CRM</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8b4ef;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            background: #f399dd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Perfil do Cliente</h2>
        <hr>

        <!-- Exibe as iniciais do cliente no avatar. -->
        <div class="avatar">
            <?php echo gerarIniciais($nomeUsuario); ?>
        </div>

        <p>
            <strong>Nome:</strong>
            <?php echo $nomeUsuario; ?>
        </p>

        <!-- Remove os pontos e o traço do CPF. -->
        <p>
            <strong>CPF para o Banco:</strong>
            <?php echo limparDocumento($cpfDigitado); ?>
        </p>

        <!-- Exibe o valor original da compra. -->
        <p>
            <strong>Total Bruto:</strong>
            <?php echo formatarMoeda($valorCompra); ?>
        </p>

        <?php
        // Aplica 10% de desconto no valor da compra.
        aplicarDesconto($valorCompra, 10);
        ?>

        <!-- Exibe o valor após o desconto. -->
        <p>
            <strong>Total com Desconto (10%):</strong>
            <?php echo formatarMoeda($valorCompra); ?>
        </p>
    </div>
</body>
</html>
