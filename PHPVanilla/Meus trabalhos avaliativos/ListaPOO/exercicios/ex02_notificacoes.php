<?php
declare(strict_types=1);

// Representa o titular da conta.
class Titular
{
    public function __construct(
        private readonly string $nome,
        private readonly string $cpf
    ) {}

    public function getNome(): string
    {
        return $this->nome;
    }
}

// Contrato que todos os notificadores precisam seguir.
interface NotificadorInterface
{
    public function notificar(
        Titular $titular,
        string $mensagem
    ): bool;
}

// Notificação simulada por e-mail.
class NotificadorEmail implements NotificadorInterface
{
    public function notificar(
        Titular $titular,
        string $mensagem
    ): bool {
        echo "E-mail enviado para {$titular->getNome()}: $mensagem<br>";
        return true;
    }
}

// Notificação simulada por SMS.
class NotificadorSMS implements NotificadorInterface
{
    public function notificar(
        Titular $titular,
        string $mensagem
    ): bool {
        echo "SMS enviado para {$titular->getNome()}: $mensagem<br>";
        return true;
    }
}

// Notificação simulada por WhatsApp.
class NotificadorWhatsApp implements NotificadorInterface
{
    public function notificar(
        Titular $titular,
        string $mensagem
    ): bool {
        echo "WhatsApp enviado para {$titular->getNome()}: $mensagem<br>";
        return true;
    }
}

// Exceção para valores inválidos.
class ValorInvalidoException extends Exception {}

// Classe abstrata que representa uma conta.
abstract class ContaBancaria
{
    private array $notificadores = [];

    public function __construct(
        protected Titular $titular,
        private float $saldo = 0.0
    ) {}

    // Cadastra um novo tipo de notificador.
    public function adicionarNotificador(
        NotificadorInterface $notificador
    ): void {
        $this->notificadores[] = $notificador;
    }

    // Envia a mensagem para todos os notificadores cadastrados.
    protected function enviarNotificacoes(string $mensagem): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->notificar($this->titular, $mensagem);
        }
    }

    // Realiza um depósito e notifica o titular.
    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor inválido.");
        }

        $this->saldo += $valor;
        $this->enviarNotificacoes("Depósito de R$ " . number_format($valor, 2, ',', '.'));
    }

    // Realiza um saque e notifica o titular.
    public function sacar(float $valor): void
    {
        if ($valor <= 0 || $valor > $this->saldo) {
            throw new ValorInvalidoException("Saque inválido.");
        }

        $this->saldo -= $valor;
        $this->enviarNotificacoes("Saque de R$ " . number_format($valor, 2, ',', '.'));
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

// Classe concreta para testar a conta.
class ContaCorrente extends ContaBancaria {}

// Criação do titular.
$titular = new Titular("Maria", "12345678900");

// Criação da conta.
$conta = new ContaCorrente($titular, 1000.00);

// Cadastro dos três notificadores.
$conta->adicionarNotificador(new NotificadorEmail());
$conta->adicionarNotificador(new NotificadorSMS());
$conta->adicionarNotificador(new NotificadorWhatsApp());

// Realização das operações.
echo "<h3>Notificações bancárias</h3>";

$conta->depositar(500.00);
$conta->sacar(200.00);

// Exibição do saldo.
echo "<br>Saldo final: R$ " . number_format($conta->getSaldo(), 2, ',', '.');
