<?php

declare(strict_types=1);

// Questão 05 - os métodos imprimem. Refatore para que devolvam o valor.
class Retangulo
{
    public float $largura;
    public float $altura;

    public function area(): float
    {
        return $this->largura * $this->altura;
    }

    public function perimetro(): float
    {
        return 2 * ($this->largura + $this->altura);
    }
}

$sala = new Retangulo();
$sala->largura = 8;
$sala->altura = 6;

echo "Área: " . $sala->area() . "\n";
echo "Perímetro: " . $sala->perimetro() . "\n";

$quarto = new Retangulo();
$quarto->largura = 4;
$quarto->altura = 3;

$comodos = [$sala, $quarto];
$areaTotal = 0.0;

foreach ($comodos as $comodo) {
    $areaTotal += $comodo->area();
}

echo "Área total dos cômodos: {$areaTotal} m²\n";
