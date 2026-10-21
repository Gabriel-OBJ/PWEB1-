# Questão 01: Do array à classe

**Nível:** 🟢 Básico

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `livro-array.php` | Fornecido: o livro em array associativo |
| `livro.php` | Você cria: a classe `Livro` e dois objetos |

## 1. Análise do código

**1.1 Explique a declaração `public float $preco;`: o que é cada uma das três partes?**

- `public`: Modificador de visibilidade (acesso). Define que o atributo pode ser lido e modificado a partir de qualquer ponto do código, tanto dentro dos métodos da própria classe quanto por código externo (fora da classe).
- `float`: Declaração de tipo do atributo (*type hint* ou *typed property*). Determina que o PHP aceitará apenas valores numéricos de ponto flutuante (números decimais) para essa propriedade.
- `$preco`: O nome da propriedade (variável de instância) que armazenará o preço do livro em cada objeto instanciado.

**1.2 Compare `$livro['titulo']` (array) e `$livro1->titulo` (objeto). O que muda na escrita e o que muda no que o PHP garante?**

- **Na escrita:** No array associativo utiliza-se a sintaxe de colchetes e a chave como string entre aspas (`$livro['titulo']`). No objeto utiliza-se o operador de acesso a membros `->` (seta) seguido do nome do atributo diretamente sem aspas nem cifrão (`$livro1->titulo`).
- **No que o PHP garante:** Em arrays associativos, o PHP não garante que a chave exista (acessar uma chave inexistente gera apenas um aviso/aviso de chave indefinida) nem restringe os tipos de dados que aquela chave pode armazenar. Já no objeto com classe definida e propriedades tipadas, o PHP garante a existência formal daquele campo no modelo da classe e aplica validação de tipo de dados em tempo de execução, impedindo atribuições incompatíveis e garantindo previsibilidade.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Saída de**: `php q01-do-array-a-classe/livro.php`

```text
Vidas Secas, de Graciliano Ramos (1938)
Dom Casmurro, de Machado de Assis (1899)
object(Livro)#1 (5) {
  ["titulo"]=>
  string(11) "Vidas Secas"
  ["autor"]=>
  string(16) "Graciliano Ramos"
  ["ano"]=>
  int(1938)
  ["preco"]=>
  float(39.9)
  ["disponivel"]=>
  bool(true)
}
object(Livro)#2 (5) {
  ["titulo"]=>
  string(12) "Dom Casmurro"
  ["autor"]=>
  string(16) "Machado de Assis"
  ["ano"]=>
  int(1899)
  ["preco"]=>
  float(29.9)
  ["disponivel"]=>
  bool(false)
}
```

**Explicação:**

O código declarou a classe `Livro` com seus 5 atributos tipados, instanciou dois objetos distintos (`$livro1` e `$livro2`) com `new Livro()` e preencheu suas respectivas propriedades. A saída exibiu a linha formatada de cada livro através de interpolação de strings e, em seguida, detalhou a estrutura dos dois objetos com o `var_dump`.

**2.2 Erro ao atribuir o ano como texto (item 5)**

```text
PHP Fatal error:  Uncaught TypeError: Cannot assign string to property Livro::$ano of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q01-do-array-a-classe\livro.php:17
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q01-do-array-a-classe\livro.php on line 17

Fatal error: Uncaught TypeError: Cannot assign string to property Livro::$ano of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q01-do-array-a-classe\livro.php:17
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q01-do-array-a-classe\livro.php on line 17
```

**Explicação:**

Ao tentar atribuir a string `'1938'` ao atributo `$livro1->ano`, o PHP disparou um erro fatal `TypeError` na linha de atribuição, pois a propriedade foi tipada com `int` e o arquivo possui a diretiva `declare(strict_types=1);`, que proíbe conversão coercitiva de string para inteiro.

## 3. Perguntas

**a) Quantas classes e quantos objetos existem no seu `livro.php`?**

Existe **1 classe** (`Livro`, que funciona como o molde/estrutura) e **2 objetos** (duas instâncias criadas na memória: `$livro1` e `$livro2`).

**b) No `var_dump`, o que significam `object(Livro)#2` e o `(5)`?**

- `object(Livro)#2`: Significa que a variável armazena uma instância de objeto da classe `Livro`, e `#2` é o identificador único sequencial atribuído internamente pelo PHP para esse objeto durante o ciclo de vida da execução.
- `(5)`: Indica a quantidade total de propriedades pertencentes a esse objeto.

**c) O que o `declare(strict_types=1)` mudou no resultado do item 5?**

Sem `strict_types=1`, o PHP opera no modo de tipagem fraca/coercitiva e realiza a coerção silenciosa da string numérica `'1938'` para o inteiro `1938`, permitindo a atribuição sem erros. Com `declare(strict_types=1);`, essa conversão automática é bloqueada, exigindo estritamente um valor do tipo `int`, o que resultou na interrupção do script com o erro fatal `TypeError`.
