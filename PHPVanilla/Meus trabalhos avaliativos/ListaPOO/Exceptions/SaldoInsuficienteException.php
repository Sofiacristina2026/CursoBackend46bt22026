<?php
declare(strict_types=1);
require_once __DIR__ . '/../Exceptions/ValorInvalidoException.php';
require_once __DIR__ . '/../Exceptions/SaldoInsuficienteException.php';

// Exceção para quando não existe saldo suficiente
class SaldoInsuficienteException extends Exception
{
}
