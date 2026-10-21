# Questão 05: `echo` ou `return`?

**Nível:** 🟡 Intermediário

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `retangulo.php` | Fornecido com métodos que imprimem. Você refatora |

## 1. Análise do código

**1.1 Cole a versão refatorada da classe e explique o que mudou em cada método.**

```php
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
```

- `area(): float`: O tipo de retorno foi modificado de `: void` para `: float`. O comando de saída `echo` foi removido e substituído pela instrução `return $this->largura * $this->altura;`. O método agora devolve o resultado numérico bruto para quem o chamou, em vez de imprimir texto acoplado no terminal.
- `perimetro(): float`: O tipo de retorno foi alterado de `: void` para `: float`. O comando `echo` foi substituído por `return 2 * ($this->largura + $this->altura);`, permitindo que o valor do perímetro seja reaproveitado em outras operações lógicas e cálculos.

**1.2 Explique como o total da área foi calculado no `foreach`.**

Inicializou-se uma variável acumuladora `$areaTotal = 0.0;`. Em seguida, percorreu-se a coleção de retângulos através de um laço `foreach ($comodos as $comodo)`. Em cada repetição, chamou-se o método `$comodo->area()`, que devolve um `float`, permitindo acumular seu valor diretamente com o operador de adição e atribuição (`$areaTotal += $comodo->area();`).

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída do código original**: `php q05-echo-ou-return/retangulo.php`

```text
Área: 48
Perímetro: 28
```

**Explicação:**

Na versão original, a execução de `$sala->area()` e `$sala->perimetro()` executava os comandos `echo` internos da classe, gerando as mensagens de texto fixas diretamente no terminal.

**2.2 Saída do teste `var_dump($sala->area())` na versão original (item 2)**

```text
Área: 48
NULL
```

**Explicação:**

Ao executar `var_dump($sala->area())`, o método `area()` primeiro executa sua instrução interna `echo "Área: 48\n"`, imprimindo a primeira linha. Em seguida, como o método foi tipado como `: void` e não possui `return`, o valor retornado pela expressão é `null`, o qual é capturado e exibido pelo `var_dump` como `NULL`.

**2.3 Saída da versão refatorada**

```text
Área: 48
Perímetro: 28
Área total dos cômodos: 60 m²
```

**Explicação:**

Com os métodos refatorados para devolverem `float`, o código consumidor pôde tanto exibir os valores individuais quanto realizar agregações matemáticas, calculando com facilidade a área somada de múltiplos cômodos (48 + 12 = 60 m²).

## 3. Perguntas

**a) O que um método `void` devolve? Use a saída 2.2 para responder.**

Um método com retorno `void` não devolve nenhum dado útil. No PHP, qualquer função ou método que não possui instrução de retorno avalia internamente para `null`, conforme demonstrado na saída 2.2 pelo `var_dump`, que exibiu explicitamente `NULL`.

**b) Por que não dava para somar as áreas na versão original?**

Porque a versão original usava `echo` e retornava `void` (`null`). Ao tentar somar o resultado de duas chamadas como `$r1->area() + $r2->area()`, estaríamos somando `null + null`, pois o valor numérico do cálculo ficava preso no fluxo de saída do terminal e nunca era entregue de volta para o chamador.

**c) Cite uma situação em que um método com `echo` faz sentido.**

Faz sentido em classes e componentes estritamente voltados para a camada de apresentação/visualização (View ou CLI), cujo único propósito de existência seja renderizar templates, exibir cabeçalhos ou imprimir relatórios finais em tela (como um método `renderizar()` ou `exibirCabecalho()`). Para classes de negócio ou modelo, deve-se sempre retornar os dados calculados com `return`.
