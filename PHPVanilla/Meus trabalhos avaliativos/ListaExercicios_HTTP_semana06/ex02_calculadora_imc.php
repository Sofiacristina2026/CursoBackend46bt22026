<?php

declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return 'Abaixo do peso';
    }

    if ($imc < 25) {
        return 'Normal';
    }

    if ($imc < 30) {
        return 'Sobrepeso';
    }

    return 'Obesidade';
}

$nome = $_POST['nome'] ?? '';
$peso = $_POST['peso'] ?? '';
$altura = $_POST['altura'] ?? '';

$erros = [];
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!is_numeric($peso) || (float) $peso < 20 || (float) $peso > 300) {
        $erros['peso'] = 'O peso deve estar entre 20 e 300 kg.';
    }

    if (!is_numeric($altura) || (float) $altura < 0.5 || (float) $altura > 2.5) {
        $erros['altura'] = 'A altura deve estar entre 0.5 e 2.5 metros.';
    }

    if (empty($erros)) {
        $imc = calcularIMC((float) $peso, (float) $altura);
        $classificacao = classificarIMC($imc);

        $resultado = [
            'imc' => $imc,
            'classificacao' => $classificacao
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>

    <style>
        .normal {
            background-color: lightgreen;
            padding: 15px;
        }

        .sobrepeso {
            background-color: yellow;
            padding: 15px;
        }

        .obesidade {
            background-color: lightcoral;
            padding: 15px;
        }
    </style>
</head>

<body>

<h1>Calculadora de IMC</h1>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome"
           value="<?= htmlspecialchars($nome) ?>">

    <br><br>

    <label>Peso (kg):</label>
    <input type="number" name="peso"
           step="0.1"
           value="<?= htmlspecialchars($peso) ?>">

    <?php if (isset($erros['peso'])): ?>
        <p><?= htmlspecialchars($erros['peso']) ?></p>
    <?php endif; ?>

    <br>

    <label>Altura (m):</label>
    <input type="number" name="altura"
           step="0.01"
           value="<?= htmlspecialchars($altura) ?>">

    <?php if (isset($erros['altura'])): ?>
        <p><?= htmlspecialchars($erros['altura']) ?></p>
    <?php endif; ?>

    <br><br>

    <button type="submit">Calcular</button>

</form>

<?php if ($resultado !== null): ?>

    <?php
    $classe = match ($resultado['classificacao']) {
        'Normal' => 'normal',
        'Sobrepeso' => 'sobrepeso',
        'Obesidade' => 'obesidade',
        default => ''
    };
    ?>

    <div class="<?= htmlspecialchars($classe) ?>">

        <h2>Resultado</h2>

        <p>
            Nome:
            <?= htmlspecialchars($nome) ?>
        </p>

        <p>
            IMC:
            <?= number_format($resultado['imc'], 2, ',', '.') ?>
        </p>

        <p>
            Classificação:
            <?= htmlspecialchars($resultado['classificacao']) ?>
        </p>

    </div>

<?php endif; ?>
<style>
    body {
        background-color: pink;
        color: #d63384;
    }
</style>

</body>
</html>