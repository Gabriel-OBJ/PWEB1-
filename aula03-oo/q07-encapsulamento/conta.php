<?php

declare(strict_types=1);

// Questão 07 - a conta da aula (exemplo 05). Encapsule.
class ContaBancaria
{
    public string $titular;
    public string $numero;
    private float $saldo = 0.0;
    private array $extrato = [];

    private function registrar(string $operacao, float $valor): void
    {
        $this->extrato[] = [
            'operacao'   => $operacao,
            'valor'      => $valor,
            'saldo_apos' => $this->saldo,
        ];
    }

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException("Depósito inválido: o valor deve ser positivo.");
        }
        $this->saldo += $valor;
        $this->registrar('Depósito', $valor);
    }

    public function sacar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException("Saque inválido: o valor deve ser positivo.");
        }
        if ($valor > $this->saldo) {
            throw new InvalidArgumentException("Saldo insuficiente para realizar o saque.");
        }
        $this->saldo -= $valor;
        $this->registrar('Saque', $valor);
    }

    public function consultarSaldo(): float
    {
        return $this->saldo;
    }

    public function apresentarDados(): void
    {
        echo "Titular: {$this->titular}\n";
        echo "Conta: {$this->numero}\n";
        echo 'Saldo: R$ ' . number_format($this->consultarSaldo(), 2, ',', '.') . "\n";
    }

    public function imprimirExtrato(): void
    {
        echo "--- Extrato: {$this->titular} ---\n";
        foreach ($this->extrato as $item) {
            echo "{$item['operacao']}: R$ " . number_format($item['valor'], 2, ',', '.')
                . ' | Saldo: R$ ' . number_format($item['saldo_apos'], 2, ',', '.') . "\n";
        }
    }
}

$conta = new ContaBancaria();
$conta->titular = 'João';
$conta->numero = '12345';
$conta->depositar(1000);
$conta->sacar(250);
$conta->apresentarDados();

try {
    $conta->sacar(1500);
} catch (InvalidArgumentException $e) {
    echo "Saque recusado: {$e->getMessage()}\n";
}
$conta->apresentarDados();
$conta->imprimirExtrato();
