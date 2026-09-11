<?php

declare(strict_types=1);

$valorVeiculo = $_POST['valor_veiculo'] ?? '';
$valorEntrada = $_POST['valor_entrada'] ?? '';
$numeroParcelas = $_POST['numero_parcelas'] ?? '';

$erros = [];
$resultado = null;

$parcelasPermitidas = [12, 24, 36, 48, 60];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!is_numeric($valorVeiculo) || (float) $valorVeiculo <= 0) {
        $erros['valor_veiculo'] = 'Digite um valor de veículo válido.';
    }

    if (!is_numeric($valorEntrada) || (float) $valorEntrada < 0) {
        $erros['valor_entrada'] = 'Digite uma entrada válida.';
    }

    if (!in_array((int) $numeroParcelas, $parcelasPermitidas, true)) {
        $erros['numero_parcelas'] = 'Escolha um número de parcelas válido.';
    }

    if (empty($erros)) {

        $valorVeiculo = (float) $valorVeiculo;
        $valorEntrada = (float) $valorEntrada;
        $numeroParcelas = (int) $numeroParcelas;

        $entradaMinima = $valorVeiculo * 0.20;

        if ($valorEntrada < $entradaMinima) {
            $erros['valor_entrada'] =
                'A entrada deve ser de pelo menos 20% do valor do veículo.';
        }
    }

    if (empty($erros)) {

        $valorFinanciado = $valorVeiculo - $valorEntrada;

        $totalJuros = $valorFinanciado * 0.015 * $numeroParcelas;

        $totalFinanciamento = $valorFinanciado + $totalJuros;

        $valorParcela = $totalFinanciamento / $numeroParcelas;

        $resultado = [
            'financiado' => $valorFinanciado,
            'juros' => $totalJuros,
            'parcela' => $valorParcela
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Financiamento</title>
</head>

<body>

<h1>Simulador de Financiamento</h1>

<form method="POST">

    <label>Valor do veículo:</label>

    <input
        type="number"
        name="valor_veiculo"
        step="0.01"
        value="<?= htmlspecialchars((string) $valorVeiculo) ?>"
    >

    <?php if (isset($erros['valor_veiculo'])): ?>
        <p><?= htmlspecialchars($erros['valor_veiculo']) ?></p>
    <?php endif; ?>

    <br><br>

    <label>Valor da entrada:</label>

    <input
        type="number"
        name="valor_entrada"
        step="0.01"
        value="<?= htmlspecialchars((string) $valorEntrada) ?>"
    >

    <?php if (isset($erros['valor_entrada'])): ?>
        <p><?= htmlspecialchars($erros['valor_entrada']) ?></p>
    <?php endif; ?>

    <br><br>

    <label>Número de parcelas:</label>

    <select name="numero_parcelas">

        <option value="">Selecione</option>

        <?php foreach ($parcelasPermitidas as $parcela): ?>

            <option
                value="<?= $parcela ?>"
                <?= (int) $numeroParcelas === $parcela ? 'selected' : '' ?>
            >
                <?= $parcela ?>x
            </option>

        <?php endforeach; ?>

    </select>

    <?php if (isset($erros['numero_parcelas'])): ?>
        <p><?= htmlspecialchars($erros['numero_parcelas']) ?></p>
    <?php endif; ?>

    <br><br>

    <button type="submit">Calcular</button>

</form>

<?php if ($resultado !== null): ?>

    <hr>

    <h2>Memória de Cálculo</h2>

    <p>
        Valor financiado:
        R$ <?= number_format($resultado['financiado'], 2, ',', '.') ?>
    </p>

    <p>
        Total de juros:
        R$ <?= number_format($resultado['juros'], 2, ',', '.') ?>
    </p>

    <p>
        Valor de cada parcela:
        R$ <?= number_format($resultado['parcela'], 2, ',', '.') ?>
    </p>

<?php endif; ?>
<style>
    body {
        background-color: pink;
        color: #d63384;
    }

    h1 {
        color: #c2185b;
    }

    h2 {
        color: #ad1457;
    }
</style>

</body>
</html>