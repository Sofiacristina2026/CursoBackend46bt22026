<?php
declare(strict_types=1);

// Exceções personalizadas
class ValorInvalidoException extends Exception {}
class SaldoInsuficienteException extends Exception {}

// Classe abstrata da conta bancária
abstract class ContaBancaria
{
    // Saldo privado: não pode ser acessado diretamente
    private float $saldo;

    public function __construct(
        protected readonly string $titular,
        float $saldoInicial = 0.0
    ) {
        if ($saldoInicial < 0) {
            throw new ValorInvalidoException("Saldo inicial inválido!");
        }

        $this->saldo = $saldoInicial;
    }

    // Impede alterações externas nas propriedades
    public function __set(string $nome, mixed $valor): void
    {
        throw new Error("Acesso negado: propriedade privada!");
    }

    // Consulta o saldo sem permitir alteração direta
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    // Realiza um depósito
    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido!");
        }

        $this->saldo += $valor;
    }

    // Realiza um débito protegido
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

    // Obriga as classes filhas a implementar o saque
    abstract public function sacar(float $valor): void;
}

// Classe concreta de conta corrente
class ContaCorrente extends ContaBancaria
{
    public function __construct(
        string $titular,
        float $saldoInicial = 0.0
    ) {
        parent::__construct($titular, $saldoInicial);
    }

    // Implementa o saque
    public function sacar(float $valor): void
    {
        $this->debitar($valor);
    }
}

// AUDITORIA DE ENCAPSULAMENTO

$conta = new ContaCorrente("Maria", 1000.00);

$totalTestes = 0;
$violacoesBloqueadas = 0;

echo "<h2>Auditoria de encapsulamento</h2>";

// TESTE 1: tentativa de alterar o saldo privado
$totalTestes++;

try {
    $conta->saldo = 5000.00;
    echo "Teste 1: acesso permitido.<br>";
} catch (Error $erro) {
    $violacoesBloqueadas++;
    echo "Teste 1 bloqueado: propriedade privada protegida.<br>";
}

// TESTE 2: tentativa de instanciar classe abstrata
$totalTestes++;

try {
    $teste = new ContaBancaria("João", 1000.00);
    echo "Teste 2: classe instanciada.<br>";
} catch (Error $erro) {
    $violacoesBloqueadas++;
    echo "Teste 2 bloqueado: classe abstrata não pode ser instanciada.<br>";
}

// TESTE 3: tentativa de depósito negativo
$totalTestes++;

try {
    $conta->depositar(-100.00);
    echo "Teste 3: depósito permitido.<br>";
} catch (ValorInvalidoException $erro) {
    $violacoesBloqueadas++;
    echo "Teste 3 bloqueado: valor inválido.<br>";
}

// RELATÓRIO FINAL
$protecao = ($violacoesBloqueadas / $totalTestes) * 100;

echo "<h3>Relatório de segurança</h3>";
echo "Testes realizados: $totalTestes<br>";
echo "Violações bloqueadas: $violacoesBloqueadas<br>";
echo "Proteção: " . number_format($protecao, 0) . "%";
