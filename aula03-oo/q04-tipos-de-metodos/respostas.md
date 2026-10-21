# Questão 04: Tipos de métodos

**Nível:** 🟡 Intermediário

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `termostato.php` | Fornecido. Você acrescenta dois métodos no item 4 |

## 1. Análise do código

**1.1 ANTES de executar, classifique os métodos:**

| Método | Tipo de retorno | Recebe parâmetro? | Altera o objeto? | Tipo do método |
|---|---|---|---|---|
| `getTemperatura()` | `float` | Não | Não | De consulta / Leitor (*getter*) |
| `definirAlvo()` | `void` | Sim (`float $alvo`) | Sim | Modificador (*setter*) |
| `resfriar()` | `void` | Sim (`float $graus`) | Sim | Modificador / Ação |
| `precisaResfriar()` | `bool` | Não | Não | De consulta / Predicado (booleano) |
| `mostrarStatus()` | `void` | Não | Não | De ação / Exibição |

**1.2 ANTES de executar, escreva as 5 linhas que você espera ver na saída:**

```text
Laboratório 1: 25 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 24 °C) - ok
33
bool(false)
```

**1.3 Cole os dois métodos novos (`aquecer` e `diferencaParaAlvo`) e classifique cada um.**

```php
    public function aquecer(float $graus): void
    {
        $this->temperatura += $graus;
    }

    public function diferencaParaAlvo(): float
    {
        return abs($this->temperatura - $this->alvo);
    }
```

- `aquecer(float $graus): void`: Método **modificador / de ação**. Recebe um parâmetro (`float $graus`), não possui retorno (`void`) e **altera o estado do objeto**, incrementando o atributo `$this->temperatura`.
- `diferencaParaAlvo(): float`: Método **de consulta / com retorno**. Não recebe parâmetros, possui retorno do tipo `float` e **não altera o estado do objeto**, calculando e devolvendo a distância numérica absoluta entre a temperatura atual e o alvo definido.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída do código original**: `php q04-tipos-de-metodos/termostato.php`

```text
Laboratório 1: 25 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 24 °C) - ok
33
bool(false)
```

**Explicação:**

1. Na primeira chamada de `mostrarStatus()`, a temperatura é 25 °C e o alvo é 22 °C. Como 25 > 22, `precisaResfriar()` é verdadeiro e imprime `resfriando`.
2. Ao executar `resfriar(2)`, a temperatura passa para 23 °C. Como 23 > 22, continua `resfriando`.
3. Ao executar `definirAlvo(24)`, o alvo passa a 24 °C. Como agora 23 não é maior que 24, imprime `ok`.
4. O `echo $sala->getTemperatura() + 10` obtém o valor numérico 23 e soma 10, exibindo `33`.
5. O `var_dump($sala->precisaResfriar())` avalia se 23 > 24, exibindo `bool(false)`.

**2.2 Saída com os métodos novos**

```text
Laboratório 1: 25 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 22 °C) - resfriando
Laboratório 1: 23 °C (alvo 24 °C) - ok
33
bool(false)
Laboratório 1: 26 °C (alvo 24 °C) - resfriando
2
```

**Explicação:**

Após o teste original, foi chamado `$sala->aquecer(3)`, elevando a temperatura de 23 °C para 26 °C. Na chamada subsequente de `mostrarStatus()`, como a temperatura (26 °C) superou o alvo (24 °C), o status voltou para `resfriando`. Por fim, `diferencaParaAlvo()` calculou a diferença absoluta entre 26 e 24, resultando em `2`.

## 3. Perguntas

**a) Sua previsão do item 1.2 acertou todas as linhas? Explique cada diferença.**

Sim, a previsão acertou exatamente todas as 5 linhas. A simulação mental do fluxo de execução acompanhou com exatidão a mutação das propriedades do objeto em cada chamada (`resfriar` e `definirAlvo`), a lógica booleana de `precisaResfriar()` e a operação aritmética sobre o retorno do *getter*.

**b) Por que `echo $sala->getTemperatura() + 10` funciona, mas `$sala->mostrarStatus() + 10` não faria sentido?**

Porque `getTemperatura()` devolve um valor numérico (`float`), podendo ser utilizado diretamente em expressões matemáticas. Em contrapartida, `mostrarStatus()` tem como única finalidade produzir uma saída de texto no terminal e possui retorno `void` (devolve `null` internamente). Não faz sentido somar 10 ao retorno de uma função que não devolve valor numérico.

**c) Qual método chama outro método do mesmo objeto?**

O método `mostrarStatus()`, que invoca `$this->precisaResfriar()` internamente na expressão ternária:
```php
$situacao = $this->precisaResfriar() ? 'resfriando' : 'ok';
```
para determinar o texto do status a ser exibido.
