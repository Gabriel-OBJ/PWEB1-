# Questão 06: Construtor

**Nível:** 🟡 Intermediário

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `produto.php` | O Produto da aula. Você acrescenta o construtor |
| `teste-erros.php` | Fornecido: três criações erradas, uma de cada vez |

## 1. Análise do código

**1.1 Cole o seu construtor e explique cada linha.**

```php
    public function __construct(string $nome, float $preco, int $quantidade = 1)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }
```

- `public function __construct(string $nome, float $preco, int $quantidade = 1)`: Declara o método especial construtor com visibilidade pública. Ele exige obrigatoriamente dois parâmetros tipados (`$nome` do tipo `string` e `$preco` do tipo `float`) e define um terceiro parâmetro opcional (`$quantidade` do tipo `int`) que assume o valor padrão `1` caso seja omitido na chamada.
- `$this->nome = $nome;`: Atribui o valor recebido pelo parâmetro `$nome` à propriedade `$nome` da instância que está sendo criada.
- `$this->preco = $preco;`: Atribui o valor numérico de ponto flutuante recebido em `$preco` à propriedade `$preco` do objeto.
- `$this->quantidade = $quantidade;`: Atribui a quantidade (seja o valor explicitamente passado ou o valor padrão `1`) à propriedade `$quantidade` do objeto.

**1.2 Explique o `= 1` no parâmetro `$quantidade`.**

O `= 1` define um **valor padrão** (*default argument value*) para o parâmetro `$quantidade`, tornando-o opcional na instanciação do objeto. Isso permite instanciar um produto passando apenas o nome e o preço (ex.: `new Produto('Mouse', 50.00)`), hipótese em que o PHP atribuirá automaticamente o valor inteiro `1` à propriedade `$quantidade`, sem gerar exceção de argumentos insuficientes.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída de**: `php q06-construtor/produto.php`

```text
Produto: Notebook
Preço unitário: R$ 3.500,00
Quantidade: 3
Total: R$ 10.500,00
Preço após desconto: R$ 3.150,00
```

**Explicação:**

O objeto foi instanciado com `new Produto('Notebook', 3500.00, 3)`. O construtor garantiu a inicialização imediata de todas as suas propriedades. Os métodos executaram perfeitamente: `apresentar()` exibiu os detalhes formatados, `calcularTotal()` retornou 10500.00 (3500 * 3) e `aplicarDesconto(10)` deduziu 10% do valor unitário, resultando em 3150.00.

**2.2 Erro com `new Produto('Teclado')`**: `php q06-construtor/teste-erros.php`

```text
PHP Fatal error:  Uncaught ArgumentCountError: Too few arguments to function Produto::__construct(), 1 passed in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 9 and at least 2 expected in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(9): Produto->__construct('Teclado')
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12

Fatal error: Uncaught ArgumentCountError: Too few arguments to function Produto::__construct(), 1 passed in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 9 and at least 2 expected in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(9): Produto->__construct('Teclado')
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12
```

**Explicação:**

O construtor exige no mínimo dois parâmetros obrigatórios (`$nome` e `$preco`). Ao passar apenas `'Teclado'`, foi fornecido apenas 1 argumento, disparando o erro fatal `ArgumentCountError`.

**2.3 Erro com `new Produto('Teclado', 'cem reais', 2)`**

```text
PHP Fatal error:  Uncaught TypeError: Produto::__construct(): Argument #2 ($preco) must be of type float, string given, called in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 10 and defined in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(10): Produto->__construct('Teclado', 'cem reais', 2)
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12

Fatal error: Uncaught TypeError: Produto::__construct(): Argument #2 ($preco) must be of type float, string given, called in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 10 and defined in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(10): Produto->__construct('Teclado', 'cem reais', 2)
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12
```

**Explicação:**

O segundo argumento (`$preco`) foi tipado estritamente como `float`. A passagem de uma string não numérica (`'cem reais'`) com a diretiva `declare(strict_types=1);` causou a interrupção da execução com um `TypeError`.

**2.4 Erro com `new Produto()`**

```text
PHP Fatal error:  Uncaught ArgumentCountError: Too few arguments to function Produto::__construct(), 0 passed in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 11 and at least 2 expected in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(11): Produto->__construct()
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12

Fatal error: Uncaught ArgumentCountError: Too few arguments to function Produto::__construct(), 0 passed in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php on line 11 and at least 2 expected in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php:12
Stack trace:
#0 C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\teste-erros.php(11): Produto->__construct()
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q06-construtor\produto.php on line 12
```

**Explicação:**

Nenhum argumento foi passado (`0 passed`). Como o construtor requer ao menos 2 argumentos, a instanciação sem parâmetros violou a assinatura do método, lançando um `ArgumentCountError`.

## 3. Perguntas

**a) A mensagem diz "at least 2 expected", e não "exactly 3". Por quê?**

Porque o terceiro parâmetro (`$quantidade = 1`) possui um valor *default* (padrão) e é opcional. Dessa forma, a chamada ao construtor aceita validamente tanto 2 argumentos (usando o valor padrão para a quantidade) quanto 3 argumentos. Por isso, a exigência mínima do PHP é de "pelo menos 2" (*at least 2*).

**b) Quem devolve o objeto pronto: o `__construct` ou o `new`?**

O operador **`new`**. O método `__construct` é apenas o inicializador interno do objeto; ele prepara os atributos e não possui retorno (`return`). É o operador `new` que aloca a instância na memória, aciona o `__construct` e, ao final, devolve a referência do objeto recém-criado para quem o chamou.

**c) Que erro da versão anterior (sem construtor) deixou de ser possível?**

Deixou de ser possível criar um objeto "incompleto" ou com atributos não inicializados (*uninitialized property error*). Na versão sem construtor, era possível fazer `$p = new Produto();` e esquecer de atribuir o nome ou o preço, o que causava falhas graves e imprevisíveis mais tarde na execução. Com o construtor, a criação do objeto é atômica: ele já nasce completo, consistente e com todas as variáveis essenciais preenchidas e validadas.
