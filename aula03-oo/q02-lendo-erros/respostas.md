# Questão 02: Lendo erros de objetos

**Nível:** 🟢 Básico

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `erros.php` | Fornecido com quatro erros. Corrija um de cada vez |

## 1. Análise do código

**1.1 Preencha a tabela, na ordem em que os erros apareceram:**

| Rodada | Linha | Tipo da mensagem (Warning ou Fatal error) | O que estava errado | Como corrigiu |
|---|---|---|---|---|
| 1 | 19 | Warning (seguido de Fatal error na linha 20) | Sintaxe incorreta `$aluno->$nome`: o cifrão extra faz o PHP buscar uma variável local `$nome` inexistente para usá-la como nome dinâmico da propriedade | Substituído por `$aluno->nome = 'Carla';`, removendo o cifrão do nome da propriedade |
| 2 | 20 | Fatal error (`TypeError`) | Atribuição da string `'3'` à propriedade `$semestre`, que foi tipada estritamente como `public int $semestre;` com `declare(strict_types=1);` | Substituído por `$aluno->semestre = 3;`, atribuindo um número inteiro literal |
| 3 | 21 | Fatal error (`Error`) | Tentativa de leitura da propriedade tipada `$curso` antes de sua inicialização (*Typed property must not be accessed before initialization*) | Atribuído um valor antes da leitura: `$aluno->curso = 'Sistemas para Internet';` |
| 4 | 14 | Warning | Dentro de `apresentar()`, utilizou-se `$nome` como variável local, mas a variável local não foi definida naquele escopo | Substituído por `{$this->nome}`, acessando o atributo do objeto via pseudo-variável `$this` |

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Rodada 1**: `php q02-lendo-erros/erros.php`

```text
PHP Warning:  Undefined variable $nome in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 19

Warning: Undefined variable $nome in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 19
PHP Deprecated:  Creation of dynamic property Aluno::$ is deprecated in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 19

Deprecated: Creation of dynamic property Aluno::$ is deprecated in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 19
PHP Fatal error:  Uncaught TypeError: Cannot assign string to property Aluno::$semestre of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:20
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 20

Fatal error: Uncaught TypeError: Cannot assign string to property Aluno::$semestre of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:20
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 20
```

**2.2 Rodada 2**

```text
PHP Fatal error:  Uncaught TypeError: Cannot assign string to property Aluno::$semestre of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:20
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 20

Fatal error: Uncaught TypeError: Cannot assign string to property Aluno::$semestre of type int in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:20
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 20
```

**2.3 Rodada 3**

```text
PHP Fatal error:  Uncaught Error: Typed property Aluno::$curso must not be accessed before initialization in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:21
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 21

Fatal error: Uncaught Error: Typed property Aluno::$curso must not be accessed before initialization in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php:21
Stack trace:
#0 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 21
```

**2.4 Rodada 4**

```text
Curso: Sistemas para Internet
PHP Warning:  Undefined variable $nome in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 14

Warning: Undefined variable $nome in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q02-lendo-erros\erros.php on line 14
Sou , do 3º semestre.
```

**2.5 Execução final, sem erros**

```text
Curso: Sistemas para Internet
Sou Carla, do 3º semestre.
```

**Explicação:**

Cada erro encontrado corresponde a uma regra fundamental de orientação a objetos e tipagem no PHP moderno:
1. Propriedades de objetos são acessadas com `$objeto->propriedade` (sem `$` na propriedade).
2. Propriedades tipadas com modo estrito (`strict_types=1`) rejeitam tipos incorretos.
3. Propriedades tipadas não possuem valor padrão nulo implícito; tentar lê-las sem inicializar causa um erro fatal.
4. Para acessar atributos ou métodos da própria instância dentro de um método, é obrigatório utilizar `$this->`.

## 3. Perguntas

**a) Na rodada 1 apareceram duas mensagens. Qual delas parou o programa? Qual a diferença entre `Warning` e `Fatal error`?**

A mensagem que parou o programa foi o **Fatal error** da linha 20 (`TypeError: Cannot assign string to property Aluno::$semestre of type int`).
- **Warning:** É um aviso que indica um comportamento indesejado ou potencial problema (como ler uma variável indefinida), porém não interrompe a execução do script; o PHP continua executando as linhas subsequentes.
- **Fatal error:** É um erro crítico (ou exceção não capturada) que impede a continuidade segura do programa, interrompendo imediatamente a execução do script.

**b) Por que o erro do `$curso` só aparece na linha do `echo`, e não na linha do `new Aluno()`?**

Porque ao instanciar o objeto com `new Aluno()`, o PHP apenas aloca o objeto e registra que suas propriedades existem, mantendo propriedades tipadas em um estado interno especial "não inicializado" (*uninitialized*). O PHP não exige inicialização imediata na instanciação caso não haja construtor. A validação só ocorre quando o código tenta **ler** o conteúdo dessa propriedade (`$aluno->curso` no `echo`), instante em que o PHP detecta que não há valor atribuído e dispara o erro fatal.

**c) Dentro do método, por que é preciso escrever `$this->nome`, e não só `$nome`?**

Porque o PHP possui escopo estrito de variáveis. Variáveis declaradas sem prefixo dentro de uma função ou método são consideradas estritamente variáveis locais daquele escopo de execução. O nome `$nome` busca uma variável local inexistente dentro do método. Para referenciar atributos que pertencem à instância do objeto que está executando aquele método, o PHP exige explicitamente a pseudo-variável `$this->` (`$this->nome`).
