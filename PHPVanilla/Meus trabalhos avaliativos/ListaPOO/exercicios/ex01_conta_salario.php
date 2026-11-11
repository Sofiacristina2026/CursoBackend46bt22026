<?php
declare(strict_types=1);

// Exceções utilizadas para identificar erros nas operações.
class ValorInvalidoException extends Exception {}
class SaldoInsuficienteException extends Exception {}

// Representa o titular da conta bancária.
class Titular
{
    // O nome e o CPF não podem ser alterados depois da criação.
    public function __construct(
        private readonly string $nome,
        private readonly string $cpf
    ) {}

    // Retorna o CPF do titular.
    public function getCpf(): string
    {
        return $this->cpf;
    }
}

// Classe abstrata que representa uma conta bancária.
abstract class ContaBancaria
{
    private float $saldo;
    protected Titular $titular;

    // Inicializa o titular e o saldo da conta.
    public function __construct(Titular $titular, float $saldoInicial)
    {
        if ($saldoInicial < 0) {
            throw new ValorInvalidoException("Saldo inválido.");
        }

        $this->titular = $titular;
        $this->saldo = $saldoInicial;
    }

    // Retorna o saldo sem permitir sua alteração direta.
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    // Adiciona um valor ao saldo da conta.
    protected function creditar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido.");
        }

        $this->saldo += $valor;
    }

    // Retira um valor do saldo, verificando se existe dinheiro suficiente.
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

    // Permite depósitos comuns nas contas.
    public function depositar(float $valor, ?string $origem = null): void
    {
        $this->creditar($valor);
    }

    // Obriga as subclasses a implementarem seu próprio saque.
    abstract public function sacar(float $valor): void;

    // Retorna o titular da conta.
    public function getTitular(): Titular
    {
        return $this->titular;
    }

    // Recebe transferências somente de contas do mesmo titular.
    public function receberTransferencia(
        float $valor,
        ContaBancaria $origem
    ): void {
        if ($this->titular->getCpf() !== $origem->getTitular()->getCpf()) {
            throw new Exception("Titular diferente.");
        }

        $this->creditar($valor);
    }
}

// Classe que representa uma conta corrente.
class ContaCorrente extends ContaBancaria
{
    // Inicializa os dados utilizando o construtor da classe pai.
    public function __construct(Titular $titular, float $saldoInicial)
    {
        parent::__construct($titular, $saldoInicial);
    }

    // Realiza o saque utilizando a validação da classe pai.
    public function sacar(float $valor): void
    {
        $this->debitar($valor);
    }
}

// Classe que representa uma conta salário.
class ContaSalario extends ContaBancaria
{
    private int $saquesNoMes = 0;
    private string $mesAtual;

    // O CNPJ do empregador é definido uma única vez.
    public function __construct(
        Titular $titular,
        float $saldoInicial,
        private readonly string $cnpjEmpregador
    ) {
        parent::__construct($titular, $saldoInicial);
        $this->mesAtual = date('Y-m');
    }

    // Permite depósitos somente do empregador autorizado.
    public function depositar(float $valor, ?string $origem = null): void
    {
        if ($origem !== $this->cnpjEmpregador) {
            throw new Exception("Empregador não autorizado.");
        }

        $this->creditar($valor);
    }

    // Permite dois saques gratuitos por mês e cobra R$ 4 nos seguintes.
    public function sacar(float $valor): void
    {
        // Verifica se ocorreu a mudança de mês.
        if ($this->mesAtual !== date('Y-m')) {
            $this->saquesNoMes = 0;
            $this->mesAtual = date('Y-m');
        }

        // Calcula a taxa conforme a quantidade de saques.
        $taxa = $this->saquesNoMes >= 2 ? 4.00 : 0.00;

        // Retira o valor solicitado junto com a taxa, quando existir.
        $this->debitar($valor + $taxa);
        $this->saquesNoMes++;
    }

    // Transfere dinheiro somente para contas do mesmo titular.
    public function transferir(float $valor, ContaBancaria $destino): void
    {
        if ($this->titular->getCpf() !== $destino->getTitular()->getCpf()) {
            throw new Exception("Transferência para terceiros proibida.");
        }

        $this->sacar($valor);
        $destino->receberTransferencia($valor, $this);
    }
}

// Cria um titular e uma conta salário para testar o sistema.
$titular = new Titular("Maria", "12345678900");
$conta = new ContaSalario(
    $titular,
    1000.00,
    "12345678000199"
);

// Executa as operações e apresenta o saldo final.
try {
    $conta->depositar(500.00, "12345678000199");
    $conta->sacar(100.00);
    $conta->sacar(100.00);
    $conta->sacar(100.00);

    echo "Saldo final: R$ ";
    echo number_format($conta->getSaldo(), 2, ',', '.');
} catch (Throwable $erro) {
    // Exibe a mensagem caso alguma operação apresente erro.
    echo "Erro: " . $erro->getMessage();
}
