# Questão 03: Métodos e `$this`

**Nível:** 🟢 Básico

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `aluno.php` | Fornecido com os métodos a completar |

## 1. Análise do código

**1.1 Cole o código dos três métodos que você escreveu e explique cada um.**

```php
    public function calcularMedia(): float
    {
        return ($this->nota1 + $this->nota2) / 2;
    }

    public function situacao(): string
    {
        $media = $this->calcularMedia();
        if ($media >= 7.0) {
            return 'Aprovado';
        }
        if ($media >= 4.0) {
            return 'Recuperação';
        }
        return 'Reprovado';
    }

    public function apresentar(): void
    {
        $mediaFormatada = number_format($this->calcularMedia(), 1, ',', '.');
        echo "{$this->nome}: média {$mediaFormatada} ({$this->situacao()})\n";
    }
```

- `calcularMedia(): float`: Acessa os atributos `$this->nota1` e `$this->nota2` do objeto em execução, calcula a média aritmética simples somando-as e dividindo por 2, e devolve o resultado como ponto flutuante.
- `situacao(): string`: Chama `$this->calcularMedia()` e aplica a lógica condicional: se a média for maior ou igual a 7.0, devolve a string `'Aprovado'`; se for maior ou igual a 4.0, devolve `'Recuperação'`; caso contrário, devolve `'Reprovado'`.
- `apresentar(): void`: Formata a média calculada para uma casa decimal com vírgula via `number_format`, invoca `$this->situacao()` e imprime diretamente no terminal a mensagem formatada com o nome, média e situação do aluno. Possui retorno `void` (não devolve valor).

**1.2 Classifique os três métodos: de ação, com retorno, com parâmetros, modificador ou de consulta? Justifique.**

- `calcularMedia()`: **Método de consulta / com retorno**. Não recebe parâmetros, não altera o estado do objeto (não modifica nenhum atributo) e calcula/devolve uma informação (`float`).
- `situacao()`: **Método de consulta / com retorno**. Não recebe parâmetros, não altera o estado do objeto e devolve uma informação baseada no estado atual (`string`).
- `apresentar()`: **Método de ação / sem retorno (`void`)**. Não recebe parâmetros e não altera o estado do objeto, mas executa uma ação de exibição externa (efeito colateral no terminal através de `echo`).

Nenhum dos três é classificado como *modificador* (*mutator*), pois nenhum altera as propriedades (`$nome`, `$nota1`, `$nota2`) do objeto.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída de**: `php q03-metodos-this/aluno.php`

```text
Ana: média 8,8 (Aprovado)
Bruno: média 5,5 (Recuperação)
Caio: média 2,8 (Reprovado)
```

**Explicação:**

Cada um dos três objetos instanciados executou o método `apresentar()`. O método acessou as notas específicas daquela instância via `$this`, calculou a média e imprimiu a situação correspondente: Ana obteve média 8,8 (Aprovado), Bruno 5,5 (Recuperação) e Caio 2,8 (Reprovado).

**2.2 Saída com o quarto aluno (notas 6,5 e 7,5)**

```text
Ana: média 8,8 (Aprovado)
Bruno: média 5,5 (Recuperação)
Caio: média 2,8 (Reprovado)
Daniel: média 7,0 (Aprovado)
```

**Explicação:**

Foi criado um quarto aluno (`Daniel`) com notas 6.5 e 7.5. Sua média aritmética foi exatamente 7,0. Como o critério de aprovação estipula `media >= 7.0`, o valor 7,0 atendeu à condição e ele foi classificado corretamente como "Aprovado".

## 3. Perguntas

**a) Por que `situacao()` chama `$this->calcularMedia()` em vez de repetir a conta?**

Para respeitar o princípio de responsabilidade única e o princípio DRY (*Don't Repeat Yourself* - não repita a si mesmo). Centralizando a regra da média em `calcularMedia()`, se no futuro o cálculo mudar (por exemplo, introdução de pesos ou nota de corte diferente), a alteração será realizada em um único local, sem risco de inconsistência entre a média exibida e a situação do aluno.

**b) Com média exatamente 7,0, qual é a situação? Qual linha do código decide isso?**

A situação é **'Aprovado'**. A linha que decide isso é:
```php
if ($media >= 7.0) {
```
O uso do operador de comparação maior ou igual (`>=`) inclui o limite exato 7.0 dentro da condição de aprovação.

**c) O método `apresentar()` foi escrito uma vez. Como ele sabe se deve mostrar a Ana ou o Bruno?**

Através da pseudo-variável `$this`. Em tempo de execução, `$this` faz referência direta ao objeto específico que chamou o método naquele instante. Ao chamar `$ana->apresentar()`, `$this` aponta para a instância da Ana; ao chamar `$bruno->apresentar()`, `$this` aponta para a instância do Bruno.
