# Questão 08: Desafio: a turma na web

**Nível:** 🔴 Avançado

## Arquivos desta questão

| Arquivo | O que é |
|---|---|
| `turma.php` | Você cria do zero: as classes `Aluno` e `Disciplina` e a página HTML |

## 1. Análise do código

**1.1 Desenhe (em texto ou tabela) as duas classes: atributos com tipo e visibilidade e métodos com tipo de retorno.**

### Classe `Aluno`

| Elemento | Nome | Visibilidade | Tipo / Retorno | Descrição |
|---|---|---|---|---|
| Atributo | `$nome` | `private` | `string` | Nome do aluno |
| Atributo | `$nota1` | `private` | `float` | Primeira nota parcial |
| Atributo | `$nota2` | `private` | `float` | Segunda nota parcial |
| Método | `__construct(...)` | `public` | - | Construtor que recebe nome, nota1 e nota2 |
| Método | `getNome()` | `public` | `string` | Retorna o nome do aluno |
| Método | `getNota1()` | `public` | `float` | Retorna a nota 1 |
| Método | `getNota2()` | `public` | `float` | Retorna a nota 2 |
| Método | `calcularMedia()` | `public` | `float` | Retorna a média aritmética simples das duas notas |
| Método | `situacao()` | `public` | `string` | Retorna `'Aprovado'`, `'Recuperação'` ou `'Reprovado'` |

### Classe `Disciplina`

| Elemento | Nome | Visibilidade | Tipo / Retorno | Descrição |
|---|---|---|---|---|
| Atributo | `$nome` | `private` | `string` | Nome da disciplina |
| Atributo | `$alunos` | `private` | `array` (`Aluno[]`) | Vetor contendo os objetos da classe `Aluno` |
| Método | `__construct(...)` | `public` | - | Construtor que recebe o nome da disciplina |
| Método | `getNome()` | `public` | `string` | Retorna o nome da disciplina |
| Método | `adicionarAluno(...)` | `public` | `void` | Recebe uma instância de `Aluno` e adiciona ao vetor `$alunos` |
| Método | `getAlunos()` | `public` | `array` | Retorna o vetor com todos os alunos cadastrados |
| Método | `totalAlunos()` | `public` | `int` | Retorna a contagem total de alunos matriculados |
| Método | `calcularMediaTurma()` | `public` | `float` | Calcula e retorna a média aritmética geral de todos os alunos |

**1.2 Explique `adicionarAluno(Aluno $aluno)`: o que significa um parâmetro do tipo de uma classe?**

Significa a aplicação de **tipagem por classe** (*Class Type Hinting*). Ao declarar `Aluno $aluno`, o PHP impõe que o argumento passado seja obrigatoriamente um objeto instanciado a partir da classe `Aluno` (ou de uma subclasse dela). Se qualquer outro tipo de dado for passado (como uma `string`, um número, um array associativo ou um objeto de outra classe), o PHP dispara imediatamente um erro fatal `TypeError`. Isso garante consistência e previsibilidade, permitindo que os métodos de `Disciplina` confiem que cada elemento dentro da coleção possui os métodos da classe `Aluno` (como `calcularMedia()`), eliminando checagens manuais repetitivas.

## 2. Saídas do terminal

> Copie do terminal e cole entre as linhas de três crases. Depois explique com suas palavras.

**2.1 Resposta da página**: `curl.exe -i http://localhost:8000/q08-turma-web/turma.php`

```text
HTTP/1.1 200 OK
Host: localhost:8000
Date: Wed, 21 Oct 2026 17:58:43 GMT
Connection: close
X-Powered-By: PHP/8.4.24
Content-type: text/html; charset=UTF-8

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turma: Programação Web</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --primary: #38bdf8;
            --success: #4ade80;
            --warning: #facc15;
            --danger: #f87171;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 800px;
        }
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
        h1, h2 {
            margin-top: 0;
            color: var(--primary);
        }
        .stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-color);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-aprovado {
            background-color: rgba(74, 222, 128, 0.15);
            color: var(--success);
        }
        .badge-recuperacao {
            background-color: rgba(250, 204, 21, 0.15);
            color: var(--warning);
        }
        .badge-reprovado {
            background-color: rgba(248, 113, 113, 0.15);
            color: var(--danger);
        }
        .teste-box {
            background-color: rgba(56, 189, 248, 0.08);
            border: 1px dashed var(--primary);
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <main class="container">
        <article class="card">
            <h1>Disciplina: Programação Web</h1>
            <div class="stats">
                <div class="stat-item">
                    <span class="stat-label">Total de Alunos</span>
                    <span class="stat-value">4</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Média Geral da Turma</span>
                    <span class="stat-value">6,8</span>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Média</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ana Silva</td>
                        <td>8,5</td>
                        <td>9,0</td>
                        <td>8,8</td>
                        <td><span class="badge badge-aprovado">Aprovado</span></td>
                    </tr>
                    <tr>
                        <td>Bruno Souza</td>
                        <td>6,0</td>
                        <td>5,5</td>
                        <td>5,8</td>
                        <td><span class="badge badge-recuperacao">Recuperação</span></td>
                    </tr>
                    <tr>
                        <td>Carla Dias</td>
                        <td>9,0</td>
                        <td>9,5</td>
                        <td>9,3</td>
                        <td><span class="badge badge-aprovado">Aprovado</span></td>
                    </tr>
                    <tr>
                        <td>Daniel Rocha</td>
                        <td>3,0</td>
                        <td>4,0</td>
                        <td>3,5</td>
                        <td><span class="badge badge-reprovado">Reprovado</span></td>
                    </tr>
                </tbody>
            </table>
        </article>
    </main>
</body>
</html>
```

**Explicação:**

O comando `curl.exe -i` realizou a requisição HTTP para o servidor embutido do PHP (`localhost:8000`). O servidor retornou o cabeçalho HTTP `200 OK` junto ao HTML renderizado. A página exibe a turma, os cards com total de alunos e a média geral calculada dinamicamente pela classe `Disciplina` (6,8), além da tabela com cada aluno, suas notas, média calculada e badge colorida da situação individual.

**2.2 Trecho da resposta com `?teste=1`**: `curl.exe -s "http://localhost:8000/q08-turma-web/turma.php?teste=1"`

```html
<section class="teste-box" id="modo-teste">
    <h2>Teste com ?teste=1: Turma Vazia de Teste</h2>
    <p>Alunos cadastrados: <strong>0</strong></p>
    <p>Média calculada da turma vazia: <strong>0,0</strong> (validação contra divisão por zero aprovada)</p>
</section>
```

**Explicação:**

Ao enviar o parâmetro de URL `?teste=1`, a aplicação detecta o parâmetro via superglobal `$_GET['teste']` e renderiza um bloco adicional de teste demonstrando o comportamento do método `calcularMediaTurma()` em um objeto `Disciplina` recém-criado sem nenhum aluno cadastrado. A validação interna evitou o erro de divisão por zero e retornou com segurança a média `0,0`.

**2.3 Log do servidor das duas requisições**

```text
[Wed Oct 21 14:58:34 2026] PHP 8.4.24 Development Server (http://localhost:8000) started
[Wed Oct 21 14:58:43 2026] [::1]:58853 Accepted
[Wed Oct 21 14:58:43 2026] [::1]:58853 [200]: GET /q08-turma-web/turma.php
[Wed Oct 21 14:58:43 2026] [::1]:58853 Closing
[Wed Oct 21 14:58:53 2026] [::1]:58854 Accepted
[Wed Oct 21 14:58:53 2026] [::1]:58854 [200]: GET /q08-turma-web/turma.php?teste=1
[Wed Oct 21 14:58:53 2026] [::1]:58854 Closing
```

**Explicação:**

O log do servidor exibe claramente o ciclo de vida de cada conexão HTTP:
1. `Accepted`: Abertura de socket/conexão para a primeira requisição.
2. `[200]: GET /q08-turma-web/turma.php`: Script executado e resposta 200 entregue.
3. `Closing`: Conexão finalizada e script encerrado.
4. `Accepted`: Nova conexão aberta para a segunda requisição (`?teste=1`).
5. `[200]: GET /q08-turma-web/turma.php?teste=1`: Novo ciclo completo de execução.
6. `Closing`: Conexão finalizada.

**2.4 Erro ao passar um texto para `adicionarAluno` (pergunta a)**

```text
PHP Fatal error:  Uncaught TypeError: Disciplina::adicionarAluno(): Argument #1 ($aluno) must be of type Aluno, string given, called in Command line code on line 1 and defined in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q08-turma-web\turma.php:67
Stack trace:
#0 Command line code(1): Disciplina->adicionarAluno('Eduardo')
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q08-turma-web\turma.php on line 67

Fatal error: Uncaught TypeError: Disciplina::adicionarAluno(): Argument #1 ($aluno) must be of type Aluno, string given, called in Command line code on line 1 and defined in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q08-turma-web\turma.php:67
Stack trace:
#0 Command line code(1): Disciplina->adicionarAluno('Eduardo')
#1 {main}
  thrown in C:\Users\luffy\Downloads\aula03-oo\aula03-oo\q08-turma-web\turma.php on line 67
```

**Explicação:**

Ao tentar passar o valor `'Eduardo'` (do tipo `string`) para o método `adicionarAluno(Aluno $aluno)`, o motor do PHP validou o tipo do argumento em tempo de execução e interrompeu imediatamente a execução com o erro fatal `TypeError`, pois uma string não é uma instância da classe `Aluno`.

## 3. Perguntas

**a) O que acontece ao chamar `$pweb->adicionarAluno('Eduardo')`? Por quê?**

O PHP dispara um erro fatal do tipo `TypeError` com a mensagem:
`Disciplina::adicionarAluno(): Argument #1 ($aluno) must be of type Aluno, string given`.
Isso acontece porque a assinatura do método exige estritamente um objeto instanciado da classe `Aluno` (`public function adicionarAluno(Aluno $aluno)`). O PHP impede que dados de tipos incompatíveis sejam repassados.

**b) Os objetos `Aluno` continuam na memória do servidor entre uma requisição e outra? Use o log para justificar.**

Não, não continuam. O modelo de execução do PHP para a web segue a arquitetura *shared-nothing* (ciclo de vida por requisição). Conforme comprovado pelo log do servidor (seção 2.3), para cada requisição há um evento de conexão aberta (`Accepted`) e, logo após a entrega do HTML, a conexão é expressamente fechada (`Closing`). Nesse instante de encerramento (`Closing`), o interpretador PHP limpa completamente a memória, destruindo todos os objetos e variáveis criados durante aquela execução. A requisição seguinte (`58854`) inicia um ambiente 100% novo e recria os objetos do zero.

**c) Por que `calcularMediaTurma()` verifica se a lista está vazia antes de dividir?**

Para prevenir o erro fatal de divisão por zero (`DivisionByZeroError`). Se uma disciplina for instanciada e não contiver nenhum aluno cadastrado (`count($this->alunos) === 0`), a divisão da soma das médias pela quantidade de alunos tentaria dividir por zero (`$soma / 0`). No PHP moderno, dividir por zero lança uma exceção fatal `DivisionByZeroError`, gerando uma falha grave (HTTP 500) na aplicação web. A verificação prévia protege o cálculo e permite retornar `0.0` com segurança.
