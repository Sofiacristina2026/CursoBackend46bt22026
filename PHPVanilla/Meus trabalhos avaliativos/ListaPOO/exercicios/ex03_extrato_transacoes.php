<?php
declare(strict_types=1);

// Exceções para tratar erros
class ValorInvalidoException extends Exception {}
class SaldoInsuficienteException extends Exception {}

// Classe que representa uma transação
class Transacao
{
    public function __construct(
        public readonly string $tipo,
        public readonly float $valor,
        public readonly string $dataHora,
        public readonly bool $sucesso
    ) {}
}

// Classe abstrata da conta bancária
abstract class ContaBancaria
{
    // Histórico protegido para as classes filhas
    protected array $historico = [];

    public function __construct(protected float $saldo = 0.0)
    {
        if ($saldo < 0) {
            throw new ValorInvalidoException("Saldo inicial inválido!");
        }
    }

    // Registra as transações
    protected function registrarTransacao(
        string $tipo,
        float $valor,
        bool $sucesso
    ): void {
        $this->historico[] = new Transacao(
            $tipo,
            $valor,
            date('d/m/Y H:i:s'),
            $sucesso
        );
    }

    // Adiciona dinheiro ao saldo
    protected function creditar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido!");
        }

        $this->saldo += $valor;
    }

    // Retira dinheiro do saldo
    protected function debitar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido!");
        }

        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException("Saldo insuficiente!");
        }

        $this->saldo -= $valor;
    }

    // Realiza um depósito e registra o resultado
    public function depositar(float $valor): void
    {
        try {
            $this->creditar($valor);
            $this->registrarTransacao('Depósito', $valor, true);
        } catch (ValorInvalidoException $erro) {
            $this->registrarTransacao('Depósito', $valor, false);
            throw $erro;
        }
    }

    // Obriga as classes filhas a implementar o saque
    abstract public function sacar(float $valor): void;

    // Retorna o histórico
    public function getExtrato(): array
    {
        return $this->historico;
    }

    // Retorna o saldo
    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

// Classe concreta de conta corrente
class ContaCorrente extends ContaBancaria
{
    public function __construct(float $saldoInicial = 0.0)
    {
        parent::__construct($saldoInicial);
    }

    // Realiza o saque e registra o resultado
    public function sacar(float $valor): void
    {
        try {
            $this->debitar($valor);
            $this->registrarTransacao('Saque', $valor, true);
        } catch (
            ValorInvalidoException | SaldoInsuficienteException $erro
        ) {
            $this->registrarTransacao('Saque', $valor, false);
            throw $erro;
        }
    }
}

// TESTES DA ATIVIDADE

$conta = new ContaCorrente(1000.00);

// Depósito de R$ 500,00
$conta->depositar(500.00);

// Saque realizado com sucesso
$conta->sacar(200.00);

// Tentativa de saque com saldo insuficiente
try {
    $conta->sacar(5000.00);
} catch (SaldoInsuficienteException $erro) {
    echo "Erro no saque: " . $erro->getMessage() . PHP_EOL;
}

// Exibição do extrato
echo PHP_EOL . "===== EXTRATO BANCÁRIO =====" . PHP_EOL;

foreach ($conta->getExtrato() as $transacao) {
    echo "Tipo: " . $transacao->tipo . PHP_EOL;
    echo "Valor: R$ " . number_format(
        $transacao->valor,
        2,
        ',',
        '.'
    ) . PHP_EOL;

    echo "Data: " . $transacao->dataHora . PHP_EOL;

    echo "Resultado: " . (
        $transacao->sucesso ? "Sucesso" : "Falha"
    ) . PHP_EOL;

    echo "---------------------------" . PHP_EOL;
}

// Exibe o saldo final
echo "Saldo final: R$ " . number_format(
    $conta->getSaldo(),
    2,
    ',',
    '.'
) . PHP_EOL;
