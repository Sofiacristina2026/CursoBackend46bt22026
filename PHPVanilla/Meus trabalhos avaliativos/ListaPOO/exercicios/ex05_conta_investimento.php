<?php
declare(strict_types=1);

// Exceções utilizadas nas operações.
class ValorInvalidoException extends Exception {}
class SaldoInsuficienteException extends Exception {}

// Classe abstrata que representa uma conta bancária.
abstract class ContaBancaria
{
    public function __construct(
        protected float $saldo = 0.0
    ) {
        if ($saldo < 0) {
            throw new ValorInvalidoException("Saldo inválido.");
        }
    }

    // Retorna o saldo atual.
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    // Adiciona dinheiro à conta.
    protected function creditar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido.");
        }

        $this->saldo += $valor;
    }

    // Retira dinheiro da conta.
    protected function debitar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido.");
        }

        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }

        $this->saldo -= $valor;
    }

    // Obriga as subclasses a implementar o saque.
    abstract public function sacar(float $valor): void;
}

// Classe que representa a conta corrente.
class ContaCorrente extends ContaBancaria
{
    // Inicializa a conta utilizando o construtor pai.
    public function __construct(float $saldoInicial = 0.0)
    {
        parent::__construct($saldoInicial);
    }

    // Realiza depósitos na conta corrente.
    public function depositar(float $valor): void
    {
        $this->creditar($valor);
    }

    // Implementa o saque da conta corrente.
    public function sacar(float $valor): void
    {
        $this->debitar($valor);
    }
}

// Classe destinada aos investimentos.
class ContaInvestimento extends ContaBancaria
{
    // Recebe a conta corrente que receberá os resgates.
    public function __construct(
        float $saldoInicial,
        private readonly ContaCorrente $contaCorrente,
        private readonly int $diasAplicacao
    ) {
        parent::__construct($saldoInicial);
    }

    // Calcula a taxa administrativa conforme o saldo acumulado.
    private function calcularTaxaAdministrativa(): float
    {
        if ($this->saldo >= 10000) {
            return 0.005;
        }

        if ($this->saldo >= 5000) {
            return 0.0075;
        }

        return 0.01;
    }

    // Calcula a alíquota regressiva de imposto de renda.
    private function calcularAliquotaIR(): float
    {
        if ($this->diasAplicacao <= 180) {
            return 0.225;
        }

        if ($this->diasAplicacao <= 360) {
            return 0.20;
        }

        if ($this->diasAplicacao <= 720) {
            return 0.175;
        }

        return 0.15;
    }

    // Calcula o IOF simplificado para o exercício.
    private function calcularIOF(float $rendimento): float
    {
        if ($this->diasAplicacao >= 30) {
            return 0.0;
        }

        $proporcao = (30 - $this->diasAplicacao) / 30;
        return $rendimento * $proporcao;
    }

    // Calcula o valor líquido após os descontos.
    private function calcularValorLiquido(float $valor): float
    {
        $rendimento = $valor * 0.10;
        $iof = $this->calcularIOF($rendimento);
        $baseIR = $rendimento - $iof;
        $ir = $baseIR * $this->calcularAliquotaIR();
        $taxa = $valor * $this->calcularTaxaAdministrativa();

        return $valor + $rendimento - $iof - $ir - $taxa;
    }

    // Resgata o investimento e transfere o valor líquido.
    public function resgatar(float $valor): void
    {
        if ($valor <= 0 || $valor > $this->saldo) {
            throw new ValorInvalidoException("Resgate inválido.");
        }

        $liquido = $this->calcularValorLiquido($valor);

        if ($liquido <= 0) {
            throw new ValorInvalidoException("Valor líquido inválido.");
        }

        $this->debitar($valor);
        $this->contaCorrente->depositar($liquido);

        echo "Resgate realizado com sucesso!<br>";
        echo "Valor líquido: R$ ";
        echo number_format($liquido, 2, ',', '.') . "<br>";
    }

    // Implementa o saque obrigatório da classe principal.
    public function sacar(float $valor): void
    {
        $this->debitar($valor);
    }
}

// Cria a conta corrente que receberá o resgate.
$contaCorrente = new ContaCorrente(500.00);

// Cria uma conta investimento com R$ 10.000,00.
$investimento = new ContaInvestimento(
    10000.00,
    $contaCorrente,
    365
);

// Realiza o resgate e apresenta os saldos.
try {
    echo "<h2>Resgate de investimento</h2>";

    $investimento->resgatar(2000.00);

    echo "<br>Saldo do investimento: R$ ";
    echo number_format($investimento->getSaldo(), 2, ',', '.');

    echo "<br>Saldo da conta corrente: R$ ";
    echo number_format($contaCorrente->getSaldo(), 2, ',', '.');
} catch (ValorInvalidoException | SaldoInsuficienteException $erro) {
    echo "Erro: " . $erro->getMessage();
}
