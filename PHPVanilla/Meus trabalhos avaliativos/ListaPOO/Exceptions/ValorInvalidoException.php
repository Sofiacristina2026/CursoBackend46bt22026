<?php
declare(strict_types=1);
require_once __DIR__ . '/../Exceptions/ValorInvalidoException.php';
require_once __DIR__ . '/../Exceptions/SaldoInsuficienteException.php';

// Exceção para valores inválidos
class ValorInvalidoException extends Exception
{
}
