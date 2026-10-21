# Questão 07: Encapsulamento

**Nível:** 🔴 Avançado

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `conta.php` | A conta da aula. Você encapsula |
| `teste-protecao.php` | Fornecido: três tentativas de burlar a classe |

## 1. Análise do código

**1.1 Cole a sua classe e explique: quais atributos e métodos são `private`, quais são `public` e por quê.**

```php
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
```

- **Atributos `private`:**
  - `$saldo`: O saldo é o dado mais crítico da conta. Deve ser `private` para impedir que código externo faça alterações arbitrárias (como atribuir valores negativos ou inventar dinheiro). A alteração do saldo passa obrigatoriamente pelas regras dos métodos `depositar()` e `sacar()`.
  - `$extrato`: Deve ser `private` para que o histórico financeiro seja imutável por fora, garantindo que nenhum agente externo consiga alterar ou forjar lançamentos.
- **Métodos `private`:**
  - `registrar()`: É um método utilitário interno. Não deve fazer parte da interface pública porque clientes externos não devem registrar transações diretamente sem movimentar o saldo real da conta.
- **Atributos e Métodos `public`:**
  - `$titular` e `$numero`: Identificam a conta e são públicos para simplificação didática.
  - `depositar()`, `sacar()`, `consultarSaldo()`, `apresentarDados()` e `imprimirExtrato()`: Formam a interface pública oficial da classe, permitindo que o sistema interaja de forma segura com o objeto.

**1.2 Explique o método privado `registrar()` e como o extrato é montado.**

O método privado `registrar(string $operacao, float $valor): void` cria um registro estruturado na forma de array associativo contendo o nome da operação realizada (`'Depósito'` ou `'Saque'`), o valor transacionado e o saldo consolidado imediatamente após a operação (`$this->saldo`). Esse registro é anexado ao final do array `$this->extrato[]`. Como ele só é invocado internamente dentro de `depositar()` e `sacar()` após todas as validações terem passado, o extrato é uma trilha de auditoria fiel e cronológica das operações efetivadas.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída com `$conta->saldo = -300;` na versão original (item 1)**

```text
Titular: João
Conta: 12345
Saldo: R$ 750,00
Titular: João
Conta: 12345
Saldo: R$ -300,00
```

**Explicação:**

Na versão original sem encapsulamento, a propriedade `$saldo` era pública. Qualquer linha de código externa conseguia sobrescrever seu valor diretamente (`$conta->saldo = -300;`), ignorando as regras de saque e depósito e colocando o objeto em um estado bancário ilegal (saldo negativo sem cheque especial).

**2.2 Saída da versão encapsulada**: `php q07-encapsulamento/conta.php`

```text
Titular: João
Conta: 12345
Saldo: R$ 750,00
Saque recusado: Saldo insuficiente para realizar o saque.
Titular: João
Conta: 12345
Saldo: R$ 750,00
--- Extrato: João ---
Depósito: R$ 1.000,00 | Saldo: R$ 1.000,00
Saque: R$ 250,00 | Saldo: R$ 750,00
```

**Explicação:**

A conta processou um depósito de R$ 1.000,00 e um saque de R$ 250,00, ficando com R$ 750,00 de saldo. Em seguida, a tentativa de sacar R$ 1.500,00 disparou uma exceção tratada no `catch`, mantendo o saldo protegido em R$ 750,00. O extrato exibiu apenas as movimentações legítimas e confirmadas.

**2.3 Tentativa 1: `$conta->saldo = -300;`**: `php q07-encapsulamento/teste-protecao.php`

```text
PHP Fatal error:  Uncaught Error: Cannot access private property ContaBancaria::$saldo in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:9
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 9

Fatal error: Uncaught Error: Cannot access private property ContaBancaria::$saldo in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:9
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 9
```

**Explicação:**

Ao tentar alterar `$saldo` diretamente por fora, o PHP impediu o acesso e lançou um erro fatal `Error: Cannot access private property`, provando que o atributo está blindado contra manipulação externa.

**2.4 Tentativa 2: `$conta->registrar(...)`**

```text
PHP Fatal error:  Uncaught Error: Call to private method ContaBancaria::registrar() from global scope in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:10
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 10

Fatal error: Uncaught Error: Call to private method ContaBancaria::registrar() from global scope in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:10
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 10
```

**Explicação:**

O método `registrar()` foi configurado com visibilidade `private`. Qualquer tentativa de invocá-lo fora da classe é bloqueada pelo PHP com o erro `Call to private method ... from global scope`, impedindo a inserção de registros fraudulentos.

**2.5 Tentativa 3: `echo $conta->saldo;`**

```text
PHP Fatal error:  Uncaught Error: Cannot access private property ContaBancaria::$saldo in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:11
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 11

Fatal error: Uncaught Error: Cannot access private property ContaBancaria::$saldo in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php:11
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q07-encapsulamento\teste-protecao.php on line 11
```

**Explicação:**

A visibilidade privada proíbe tanto a escrita quanto a leitura direta da propriedade. Para ler o saldo de forma autorizada, deve-se chamar o método público leitor `consultarSaldo()`.

## 3. Perguntas

**a) Por que a conta não tem um método `setSaldo()`?**

Porque fornecer um `setSaldo()` anularia o encapsulamento, permitindo que qualquer parte do sistema redefina o saldo para qualquer valor arbitrário sem passar por validações de regras de negócio. O saldo de uma conta não deve ser simplesmente "setado"; ele é o resultado acumulado de transações legítimas de depósito e saque.

**b) Qual a diferença entre a versão original (`echo` + `return`) e a nova (`throw`) quando uma operação é inválida?**

Na versão original com `echo` + `return`, a classe tratava o erro apenas gerando texto no terminal e retornando silenciosamente. O código que chamou o método não tinha como saber de forma programática que a operação falhou e continuava a execução normalmente. Com o lançamento de exceções (`throw`), o fluxo de execução é imediatamente interrompido na falha, forçando o chamador a capturar e tratar o erro de maneira explícita e controlada.

**c) O que acontece com o saldo quando um saque é recusado? Use a saída 2.2.**

O saldo permanece inalterado. Na saída 2.2, o saldo era de R$ 750,00 antes da tentativa de saque de R$ 1.500,00 e permaneceu exatamente em R$ 750,00 após a recusa. Isso ocorre porque a validação com `throw` é executada antes de qualquer instrução de subtração (`$this->saldo -= $valor;`), garantindo que o estado interno do objeto não seja corrompido em caso de erro.
