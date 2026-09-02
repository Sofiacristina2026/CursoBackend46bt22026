# Curso Backend - 225h - Tecnico em  
Sistemas - Senai

Profº Diogo TB

Escola SENAI Americana 
2º Semestre 2026

Aluna: Sofia Cristina

## Objetivos do curso

-Desenvolver aplicações Web Server Side, Utilizando a linguagem PHP:
- Aplicar Sisntaxe Nativa PP(Vanilla):
- Manipulação HTTP:
- Persistencia de dados:
- Segurança conta SQL Injection /CRSF;
- Refatoração em POO ( Programação Orientada ao Objeto);
- Arquitetura MVC (Model, View , Controller);
- Utilizaçãop do Framework Larevel;

# Observação 
Frameork - É um conjunto de Bibliotecas que oferecem uma solução completa para o desenvolvimento de alguma coisa

# Cronograma do Semestre 

Carga horária: 105h 1º Semestre e 120h 2º Semestre

Duração:  20 Semanas 1º Semestre e 20 Semanas 2º Semestre

### Semana 1: Introdução ao BackEnd e Configuração do Ambiente PHP

# O que é BackEnd ?
 - O backend é a parte de um sistema ou site que fica nos bastidores. 
 Ele cuida do servidor, do banco de dados e da lógica do sistema, processando as informações que o usuário não vê diretamente.
 
# Como o Backend Funciona 
  - Servidor: O computador central que recebe o que você pede na tela e envia a resposta de volta.
  - Banco de dados: Onde ficam guardadas as informações, como senhas, nomes de usuários e produtos.
  - Regras de negócio: A lógica que faz o sistema funcionar, como calcular o frete de uma compra ou conferir se a senha está certa.
 
 # Principais Tecnologias Linguagens de programação: 
 Ferramentas usadas para escrever o código do servidor, como Python, Node.js (JavaScript), Java e PHP.APIs: Os "caminhos" que permitem que o que você vê no celular converse com o servidor.

 # Sobre o mercado atual:
  o cenário é bom, mas mais exigente do que era. Quem conhece só o básico enfrenta mais concorrência. Quem alia backend sólido com IA aplicada, cloud e inglês está num patamar completamente diferente — vagas internacionais remotas são uma realidade pra esse perfil.

  # Para que serve
-Processar lógica de negócio: regras, cálculos, validações (ex: calcular frete, aplicar desconto, validar login)

-Gerenciar banco de dados: salvar, buscar, atualizar e deletar informações

-Autenticação e autorização: controlar quem pode acessar o quê (login, senhas, permissões)

-Fornecer APIs: criar "pontes" (endpoints) para o frontend ou outros sistemas consumirem dados

-Integração com serviços externos: pagamentos, e-mails, notificações, APIs de terceiros

-Segurança: proteger dados sensíveis, evitar ataques (SQL injection, XSS, etc.)

-Escalabilidade e performance: garantir que o sistema aguente muitos usuários ao mesmo tempo.

Fintechs e Bancos
Segurança, transações, alta escala 

E-commerce
Catálogo, pedidos, pagamentos

Healthtechs
Prontuários, telemedicina

SaaS / Startups
Backend é o coração do produto

Logística
Rastreio, rotas, tempo real

Educação
Plataformas, conteúdo, usuários

## O ciclo de vida da Requisisão http

#### O que é HTTTP ?

* HTTP*, Hyptext Trasnfer Ptotocol é um protocolo de comunicação utilizado para tranfrência de informação na www ( World Wide Web ) e em outas redes.

O HHTP é a base para que o cliente e um servidor web troquem insformações.Ele permite a requisição e a resposta de recursos como imagens, arquivos e textos 

### marmaid = Diagrama 
fica lindo alias 

---
### Aula 02 De Backend

## O que é Backednd
Backend é a interface entre o servidor e o usúario. Uma resposta para uma requisição.

#### Como funciona na prática o Backend ?

- ***Ação do usúario**: Envia uma solicitação pela UI(Inteface do Usuário). Exemplo de UI: Tela do celular, Navegador da Internet,Alexa. Gemini,IOT ...
- **Enviar uma requisição**: A UI Transforma a ação do usuário em uma requisição HTTP.
-**Processamento pelo Backend**: O código backend recebe o pedido valida os dados e decide o que fazer.Exemplo:Consultar uma informação no BD(A base de dados).
- **Resposta**: O servidor devolve o resultado para a UI. Exemplo: Um login autorizado, a confirmação de uma compra...
-----

### Tipos de Requisições HTTP:

Os tipos de requisições HTTP indicam a açãoque o usuário deseja executar no servidor. As principais ações são:
 
 - **GET**: Pede dados de um luhgar específico do servidor. "Não faz alterações no servidor"
 - ** DELETE**: Apaga um dado do servidor.
 - **post**: eLA ENVIA DADOS NOVOS PARA *criar* algo ou processar insformações no servidor.
 - **PUT/PATCH**: Modificar um dado já existente.

 >Obs: Diferença entre os comando : (Put) faz uma alteração completa já o PATCH faz uma alteração parcial.
----

### Iniciando o PHP

**PHP** (hyperTxt PreProcessor) é uma linguagem de programação interpretada e open source,focada no desenvolvimento de sistemas para web,pode ser usada junto com o HTML para criaçõa de páginas web dinâmicas.

O PHP de fato é uma das linguagens de programação mais populares da  atualidade. Ela permite que você crie aplicações web robustas, de uma muito simplificada e direta. A linguagem tem diversos recursos que facilitam e aceleram o processo de desenvolvimento de sites e sistemas para web. E além do mais, ela ainda tem um otímo ecosistema, uma excelente comunidade e um grande mercado de trabalho.

-----

##### Instalando o PHP

- Fazer o Dowload do php em (php.net)
- Zip - NTS(Non Thread Safe) 8.5
- Descompactar o arquivo do PHP na pasta C:\src\php (Para descompactar usar o 7zip + melhor ) => Nunca salvar arquivos ou programas na raiz do sistema(C:)
- Adicionar a Pasta do PHP(c:\src\php) As varaiáveis de ambiente do Sistema (PATH)
- Verificar a instalação com o comando *php--version*

----
### Aula do dia 07.08
#### Criando minha primeira Aplicação em PHP 

1. Antes de começar a codar:

- Prepara meu VS Code 
  - Criar um Profile próprio para o PHP
  - Instalar as extensões necessárias para transformar o VS Code em uma IDE
      - PHP Intelephense => Permite a utilização de snippets(atalhos de codígo)
      - PHP Debug => ajuda a encontrar erros de código
      - PHP Cs Fixer =>  formatação de códigos (Identação)
      - PHP Server => ajuda na criação de um servidor local para PHP
- Desabilitamos o PHP Nativo do VsCode ( @builtin PPHP)
    
2. Hello.World (muito importante)
 
 ### Semana 2 - Variáveis, Constantes e Operadores em PHP
 #### Estudo de Variáveis e constantes em PHP 
 Declarar variáveis é alocar um espaço na memoria que permite a inclusão e manipulação de dados 

 **Variáveis**

 - Devem ser declaradas usando "$" antes do nome da variável
 - São não tipadas ou seja não precisa declarar o tipo dela na criação .
 - Podem ser String, Numericas (Interger e Float), Bollenas e Nulas. Não permite declaração de Underfined
 - Usar o "declare(Strict_types+1)" na primeira linha do arquivo => blinda o sistema contra o conflito de tipos de variáveis.

 ###Constantes###

  - Não podem ser mudadas ou redeclaradas após a criação.
  - Podem ser criadas usando o "const" ou o "define"
  - Não permite interpolação 

  >concatenação = texto +texto( jeito errado)
  exemplo: 10 + 10 = 1010

  ## Estudo de Operadores" 
 
  **Aritméticos**: São usados para realizar Cálculos
  
  |Operador | Nome | Exemplo | Resultado |
  | - | - | - | - |
  | + | Adição | 10+5 | 15 |
  | - | Subtração | 10-5 | 5 |
  | * | Multiplicação | 10*5 | 50 |
  | / | Divisão | 10/5 | 2 |
  | % | Modulo(Resto) | 10%3 | 1 (10 div 3 da 3, sobra 1 ) |
  | ** | Expoente 2**3 | 8(2 elevado a 3) |

  obs: O operador % é o melhor amigo de um programador, permite ordenar listas e organizar fila e pilhas.

 **Relacionais**: Permite o Relacionamento entre dois valores, o resultado e uma operação é sempre uma boleana (verdadeira ou falsa). 

 | Operador | Significado | Exemplo | Resultado |
 | - | - | - | - |
 | > | Maior que | 18 > 18 | False |
 | >= | Maior ou igual que | 18 >= 18 | True |
 | < | Menor que | 10 < 20 | True |
 | <= | Menor ou igual á | 10 <=5 | False |
 | == | Comparação de valor | "10" == 10 | true |
 | === | Comparação Estrita | "10" ===10 | False |
 | != | Diferente | "10" !=10 | false
 | !== | Estritamente Diferente | "10"!==10 | True |

**Logícos**: Permite a Combinação entre sentença. 

- Operador AND (E) => && : Para o resultado ser o verdadeiro, todas as combinações precisam ser verdadeiras.
     - True && True => True 
     - True && False => False

- Operador OR (OU) => : Para o resultado ser o verdadeiro, basta apenas uma digitação ser verdadeira. 
    -  False || True => True
    - False || False => False

- Operador NOT (Não) => ! : Inverte a lógica da Operação 
    -!True => False
    - !false => true
   
    ---

    ### Aula do dia 12.08
    ### Semana 3 - Estrutura de Controle de Dados (condicionais e repetição)

 - **Conteúdo**: Estrutura `if`, `else`, `elseif`, operadores ternários, `match` => substituto do `switch/case`, loops `for`, `while`, `do-while` e `foreach`

 #### Estruturas de controlde de dados ajudam no processo de Automatização em Programas de Sistemas

 ##### Condicionais (IF, ELSE, ELSEIF)

 **Formas de uso**

 - Uso do 'If" apenas:
 Exemplo: Aplicar desconto de 10% em compras acima de 100 Reais;

 ```mermaid

 graph LR

    A[Comando] --> B{Condição} -->C[Ação]

```

```php

if($valorCompra > 100){
 $valorFinal = $valorCompra * 0.9;
}

```
- Uso do `if`e do  `else`
Exemplo: Aplicar um desconto de 10% para compras acima de 100reais e 5% para as demais compras

```mermaid

graph LR

    A[Comando] --> B{Condição}
    B --> |true| C[Ação 1]
    B --> |false| D[Ação 2]

```

```php

if($valorCompra > 100){
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```

## Aula do dia 14.08
- Uso do `elseif` (If Encadeado) => estrutura usada para manipulação de dados em duas ou mais condicionais.
Exemplo:Compras acima de 200 reias tem 15%de desconto, compras acima de 100 reias tem 10% de desconto e demais compras tem 5% desconto.

```mermaid

graph LR

    A[Comando] --> B{Condição 1}
    B --> |true| C[Ação 1]
    B --> |false| D{Condição 2}
    D --> |true| E[Ação 2]
    D --> |false| F[Ação 3]

```

```php

if($valorCompra > 200 {
    $valorFinal = $valorCompra * 0.85;
} elseif($valorCompra > 100) {
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```

*obs*: sempre usar `elseif` para situações que precisam de mais de uma condição, ou seja,fazer encadeamnto das condições.

- Uso *ERRADO* do if

```php 

if($valorCompra > 200) {
    $valorFinal = $valorCompra * 0.85;
}
if($valorCompra > 100) {
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```
---

>Ele significa basicamente: "Se a primeira condição não for verdadeira, verifique esta outra condição."

>Pense nele como:
SE isso acontecer → faça isso
SENÃO SE aquilo acontecer → faça aquilo
SENÃO → faça outra coisa.

#### Operadores ternários 

Um atalho para a estrutura condicional `if/else, normalmente escrito em uma uníca linha de código.

` condição ? verdadeira : falsa ` 

Perfeito para a decisões curtas de uma linha de comando.

Exemplo: Verficar se a pessoa é maior de idade (18)

```php

$idade = 10;
//O fomrato é (condição) ? Verdadeiro : Falso;

$status = ($iddae>=18) ? "Maior de idade" : "menor de idade";
$status2 = ($idade>=60) ? "Idoso" : ($idade>=18) ? "Adulto" : "Criança" ;
'

echo $status //

```

#### Expressão Condicional `match` (PHP 8)

No mercado atual de PHP, não se uma mais uma `Switch/Case` para chegar valores fixos, usa-se o `match`. Ele compara um valor e retoran diretamente o resultado caso atenda a condição.

```mermaid

graph TD
    A[Valor] --> B{Condicional}
    B --> C[Ação 1]
    B --> D[Ação 2]
    B --> E[Ação 3]
    B --> F[Ação 4]
    B --> G[Ação ...]
    B --> H[Ação default]

```

>Usamos o `graph TD` quando queremos fazer um gráfico de cima pra baixo. Igual mapa mental

#### Exemplo de aplicação: 
Selecionar o dia da semana a partir de um Nº

```php

$diaSemanaNum = date("W"); // pega o Dia da Semana em formato numérico

$nomeDiaSemana = match($diaSemanaNu) {
    "0" => "Domingo",
    "1" => "Segunda",
    "2" => "Terça",
    "3" => "Quarta",
    "4" => "Quinta",
    "5" => "Sexta",
    "6" => "Sábado",
    "default" => "Dia Inválido"
};

echo " Hoje é : $nomeDiaSemana";

```
---

##### Laços de Repetição

Um laço de repetição faz com que um bloco de código rode várias vezes até que uma condição mande parar. 

- O Laço while (Enquanto)

Ele verifica se a condição é verdadeira ANTES de entrar no laço. Ideal quando você não sabe exatamente quantas vezes vai rodar o laço. 

```mermaid

graph LR

    A[Início: contador = 0] --> B{Verdade?}
    B -- Sim --> C[Repete]
    C --> D[executa código]
    D --> B
    B -- Não --> E[Fim do Laço]

```
Exemplo de Aplicação do While:  jogo de Adivinhação de um nº Secreto

```php

$numeroSecreto = rand(1,10);

$tentativas = 0;

$numeroEscolhido = 0;

while(numeroEscolhido != numeroSecreto){
    echo "tente novamente"
    //Vou escolher outro Nº para adivinhar
    numeroEscolhido = rand(1,10);
    tentativas++;
}
echo 'Acertou parabéns!!!! O nosso nº secreto é "$numeroEscolhido';

```
- O Laço `do-while` (Faça- Enquanto)

A diferença é que ele executa o bloco pelo menos uma vez, mesmo que a conduição seja false desde o início, pois ele só pergunta no final.

```mermaid

flowchart LR

    A([Início]) --> B[Ação]
    B --> C{Condição}
    C --true--> B
    C --false--> D([Fim])

```

Exemplo: Jogo de Adivinhação de um nº

```php

$numeroSecreto = rand(1,10);

do{
    $numeroEscolhido = rand(1,10);

    if(numeroEscolhido == numeroSecreto){
        echo "Parabens, acertou !!!";
        break
    }
    echo "Tente Novamente!!!";
}while(numeroEscolhido != numeroSecreto);
```

#### O freio de Emergência: `break` e `continue`

As vezes precisamos interferir no laço enquanto ele está rodando

As vezes precisamoso interferir no laço enquanto ele está rodando 

- `break`=> **Para Tudo!** Quebra o laço interiro e avai embora
- `continue` => **Pula a rodada!** Ele ignora o código daquela rodada especifica e pula logo par a próxima repetição.

Exemplo de Aplicação do Código: Sistema de Controle do Elevador

```php 

for($andar = 1 ; $andar<=10; $andar++){
    if($andar ==4){
        echo "Andar $andar está em obras. Passando direto!";
        continue;
    }

    echo "Elevador parou no andar $andar"
}

```
---
### Aula do dia 19/08 ###
##### Laço de Repetição `for`

Use o `for`quando você sabe quantas vezes precisa repetir uma ação ou quando precisa controle um contador. Ele possui três partes:

- inicialização,
- condição,
- incremento;

for(inicialização; condição; incremento){
    Ação
}

```mermaid

flowchart LR
    A[Início: i=0] --> B{i<10?}
    B --true--> C[Ação]
    D --> D[i++]
    B --> B
    B --false--> E[Fim]

```php
for($mes=1; $mes<=12; $mes++){
    echo "Mês $mes";
}

```

Nesse Exemplo, `$mes`começa em 1, o laço continua enquantio `$mes`for menor ou igual a 12 e, ao final de cada repetição, `$mes++`aumenta o contador em 1.

##### Laço de Repetição `foreach`

Use o `foreach` quando precisar percorrer cada item de um **array*. Ele acessa os elementos diretamente, sem que você precise controlar o contador.

Exemplo: Imprimir todos os itens de um vetor

```php

$frutas =["Maça", "Banana", "Uva", "Pera"];

foreach($frutas as $fruta){
    echo "fruta: $fruta";
}

Outro Exemplo: Acessar a chave e o valor de cada item:

```php 

$precos = [
    "Caderno" => 25.90,
    "Caneta" => 5.50,
    "Mochila" => 99.00
]; // vetor não ordenado chave => valor

foreach ($precos as $produto => $preco){
    echo "$produto: R$ number_format($preço,2)";
}
```

---
---
#### Desafio : Simulador de Cobrança (FINANÇASENAI) 
---

### AULA DO DIA 21.08 ###
### SEMANA 4 - Modularização com funções ###
#### Principio do DRY ( `Don´t Repeat) Yourself`) 

Se uma lógica foi escrita duas vezes ou mais dentro de um código, essa lógica deve virar uma função.

#### Funções Nativas do PHP

O PHPH tem milhares de funções prontas, essa funç~eos são chamadas de nativas.

- **O que é uma função?**

Uma função é como uma maquina:Você coloca uma matéria prima (que seria nosso paramêtro), ela processa e devolve um produto final(Retorno)

Exemplo de uma função Nativa:

```php

$texto= "senai americana";

//str_replace(ela busca um pedaço do texto e substitui por outro)
$textoNovo = str_replace("americana","São Paulo",$texto)
//Modificação = mudança(reescrita) (oq muda, para que ? aonde ?)

//strtouupper
echo strtoupper($textoNovo); // SENAI SÃO PAULO

```

#### Principais funções Nativas (mais utilizadas)

As funções abaixo já fazem parte do PHP e podem ser chamadas diretamente no código. Observe os parâmetros que cada uma recebe e o tipo de informação que ela retorna.

| Função | Categoria | O que faz | Como usar |
|---|---|---|---|
| `strlen()` | Strings | Retorna a quantidade de caracteres de um texto. | `$tamanho = strlen($texto);` |
| `strtoupper()` | Strings | Converte o texto para letras maiúsculas. | `$resultado = strtoupper($texto);` |
| `strtolower()` | Strings | Converte o texto para letras minúsculas. | `$resultado = strtolower($texto);` |
| `ucfirst()` | Strings | Converte a primeira letra do texto para maiúscula. | `$resultado = ucfirst($texto);` |
| `trim()` | Strings | Remove espaços e quebras de linha no início e no fim do texto. | `$limpo = trim($texto);` |
| `str_replace()` | Strings | Substitui uma parte do texto por outra. | `$novo = str_replace("-", "", $cpf);` |
| `substr()` | Strings | Extrai uma parte do texto a partir de uma posição. | `$inicio = substr($texto, 0, 3);` |
| `explode()` | Strings | Divide um texto e cria um array usando um separador. | `$palavras = explode(" ", $nome);` |
| `implode()` | Arrays | Junta os itens de um array em um único texto. | `$lista = implode(", ", $nomes);` |
| `count()` | Arrays | Conta a quantidade de itens de um array. | `$total = count($produtos);` |
| `in_array()` | Arrays | Verifica se um valor existe dentro de um array. | `$existe = in_array("SP", $estados, true);` |
| `array_push()` | Arrays | Adiciona um ou mais itens ao final de um array. | `array_push($nomes, "Ana");` |
| `array_pop()` | Arrays | Remove e retorna o último item de um array. | `$ultimo = array_pop($nomes);` |
| `sort()` | Arrays | Ordena um array em ordem crescente e reorganiza suas chaves. | `sort($notas);` |
| `array_keys()` | Arrays | Retorna um array contendo as chaves de outro array. | `$chaves = array_keys($produtos);` |
| `number_format()` | Números | Formata um número com casas decimais e separadores definidos. | `$preco = number_format($valor, 2, ',', '.');` |
| `round()` | Números | Arredonda um número para a quantidade de casas informada. | `$media = round($nota, 2);` |
| `max()` | Números | Retorna o maior valor de uma lista ou array. | `$maior = max($notas);` |
| `min()` | Números | Retorna o menor valor de uma lista ou array. | `$menor = min($notas);` |
| `is_numeric()` | Validação | Verifica se o valor é um número ou uma string numérica. | `if (is_numeric($entrada)) { ... }` |
| `isset()` | Validação | Verifica se uma variável existe e não possui valor `null`. | `if (isset($usuario)) { ... }` |
| `empty()` | Validação | Verifica se uma variável está vazia. | `if (empty($pedido)) { ... }` |
| `date()` | Data e hora | Formata uma data ou hora conforme uma máscara. | `$hoje = date('d/m/Y');` |
| `file_exists()` | Arquivos | Verifica se um arquivo ou diretório existe. | `if (file_exists('dados.txt')) { ... }` |
| `file_get_contents()` | Arquivos | Lê todo o conteúdo de um arquivo ou endereço. | `$conteudo = file_get_contents('dados.txt');` |
| `file_put_contents()` | Arquivos | Grava conteúdo em um arquivo, criando-o se necessário. | `file_put_contents('log.txt', $mensagem);` |

**Atenção:** algumas funções modificam o array original, como `sort()`, `array_push()` e `array_pop()`. Já outras retornam um novo valor, como `count()`, `explode()` e `str_replace()`. Em caso de dúvida, consulte a documentação oficial do PHP e verifique o retorno da função.

##### Documentação PHP

[Acesse a documentação oficial do PHP em português](https://www.php.net/manual/pt_BR/)

Consulte também a [referência de funções do PHP](https://www.php.net/manual/pt_BR/funcref.php) para pesquisar a sintaxe, os parâmetros eos valores por cada função.


#### Funções Customizadas (Criando suas próprias máquinas)

Quando o PHP não tem a função que queremos, nós a criamos!

**A Regra de Ouro:** Uma função deve focar em `return`(retornar um valor), e não imprimir (`echo`). 

Veja a diferença nesse exemplo:
```php

function calcularTotal($preco, $quantidade){
    //a função calcula e rotna o resultado, mas não imprime nada
    return $preco * $quantidade;
}

$total = calcularTotal(25.00, 3);

echo "Total da compra: R$ " . number_format($total, 2, ",", ".");
// Total da compra: R$ 75,00

```
A função `calcularTotal()` pode ser reutilizado em uma página, relátprio ou teste. O `echo` aparece somente fora da função, no momento de apresentar ao usuário.

#### Padrão de uso Corporativo (PHP & Strct Types)

No mercadpo de trabalaho, exigimos que a função avise exatamente o *tipo* de dado que ele espera receber e o **TIPO** que ela vai devolver.

Isso é chamado de **tipagem de funções**. Ao decalarar os tipos, o código fica mais fácil de entender e o PHP consegue indentificar erros antes que eles causem problemas maiores no sistema.

Os tipos mais usados/;

* `int`: Número inteiro `10`ou `1024`
* `float`: Número decimal ou ponto flutuante, `10,50`.
* `string`:Texto, como `Maria`
* `boll`: Valor lógico, `true` ou `false`.
* `void`: Identifica que a função não devolve nenhum valor.

O tipo deve ser escrito antes do nome de cada parâmetro e o tipo da função deve ser escrito após os parênteses precedito por `:`, informando o que a função vai devolver.

Exemplo de uso:

```php
function apresentarProduto(string $nome, float $preco): string{
    return "$nome custa R$ $preco";
}

$mensagem = apresentaproduto("Caderno", 25.90);
echo $mensagem;
//  Caderno custa R$ 25.90

```

>**Resumo**: Os tipos dos parâmetros documentam as entradas da função , o tipo após `;` documenta a saída da função.

##### O tipo Mágico: `void`

Se uma função faz um trabalho interno e **não retorna NADA** , dizemos que o retorno dela é "vazio" ou seja (`void`).

Exemplo função sem retorno:

```php
function registroLog(string $mensagwem): void{
    //apenas salvar em um arquivo de texto, não devolve nenhuma variável
    file_put_contentes("erro.log",$mensagem);
}

```

### Escopo e Referência (O segredo da memória)

#### O que é Escopo ? (A regra de Las Vegas)

* O que acontece dentro da função, fica dentro da função*. Uma variável criada fora não existe lá dentro, e uma craida lá dentro morre quando a função acaba.

**Escopo** é o local do personagem onde a váriavel pode ser armazenada/acessada. Em PHP, uma variável criada fora de uma função permanece ao **escopo global**. Uma variável criada dentro de uma função pertence ao **escopo local**.

Exemplo de Escopo de variável:´

```php
$comeSistema = "CRM Senai/"; //Variável global
function criarMensagenm():string{
    $mensagem ="Bem-Vindo!"; //Variável local
    return $menasgem;
}

echo $nomeSistema; //Correto: está no escopo global
echo criarMensagem(); //Correto: a função devolve sua variável local.
echo $mensagem: // Incorreto: $mensagem só existe dentro da função, não é acessada fora.

```
* Como enviar dados para uma função?

A forma mais segura e organizada é enviar os dados por **parâmetros**. Assim, a função não precisa acessar diretamento variáveis globais:

```php
function saudar(string $nome):string{
    return "Olá, $nome!";
}

$nomeCliente = "João";
echo saudar($nomeCliente); // Olá, João!
```

Nesse caso, `$nomeCliente` continua no escopo global, mas seu valor é enviado para o parâmetro local `$nome`. A função recebe uma informação, processa e retorna o resultado.

Exemplo Incorreto:

```php
$nome = "João";
function saudar():string{
    return "olá,$nome":
}
```
A dunção `saudar`()`não conhece a variável global `$nome`
> **Resumo:** variáveis protegem os dados internos da função; parâmetros são o caminho recomendado para evitar erros e enviar informações, e `return` é usado para devolver um resultado ao código que chamou a função.

---

### Semana 5 - Arrays e Manipulação Avançada de Dados ###
### Aula dia 02.09 #

Um array (também conhecido como vetor) é uma estrutura de dados usadas para armazenar vários valores em uma única variável.

obs: Economiza tempo de consulta, memórias e etc...

**Tipos de Arrays em PHP**

- Indexados/Ordenados(Númerica): Usam Números inteiros como índices (chaves), que começasm em zero por padrão; 
- Associativos/NãoOrdenados(String): Usam chaves Sting para identificar valores;
- Multidimensionais: Ou seja contém um ou mais arrays dentro de outro array;

**Exemplos de arrays**

```php
//array indexado
$frutas = ["maça", "banana", "laranka"];

//array associativo
$capitais = [
    "SP" => "São Paulo",
    "RJ" => "Rio de Janeiro",
    "MG" => "Belo Horizonte",
    "ES" => "Vitória",
];

//acessando os dados do arrys

echo $frutas[a];: // banana
acho $capitais ["MG"]; //Belo Horizonte
```

> OBS: Em arrays associativos, nos trocamos os nº do índice por Nomes(chaves/Keys). Na declaração do Vetor usamos setinha (=>) que significa "recebe".

#### Arrays Multidimensionais (Banco de Dados na Memória)

É aqui que o "BackEnd" começa de verdade. O array multidimensional é o formato como os BancodeDados e Apis respondem as solicitações feitas pelo BackEnd.

***Exemplo de Array Multidimelsional:**

```php
$cliente = [
    ["id" => 1, "nome", => "Ana", "Email" => "ana@email.com", "ativo" => true],
    ["id" => 1, "nome", => "Bruno", "Email" => "Bruno@email.com", "ativo" => true],
    ["id" => 1, "nome", => "Carlos", "Email" => "Carlos@email.com", "ativo" => true],

];

//Como Acessar o Email do Carlos
echo $clientes[2]["email"]; // carlos@hotmail.com
```

#### O Melhor amigo dos Array: `O Foreach`

O laço de repetição especial para arrays. O `foreach` percorre cada elementos de um array

**Exemplo de Aplicação:**

```php
foreach($clientes as $clienteAtual){
    echo $clienteAtual["nome"];
    echo $clienteAtual["email"];
}
// vai imprimir nome e email de todos os Clientes do Array
```

#### Transformação de Arrays e Arrow Function

Transformações de arrays são usadas para modificar ou filtrar informações de um array existente

- `array_filter`
Serve para buscar dados em um array e devolver apenas os dados que passarem pelo filtro

```php
$clientesAtivos = array_filter($clientes, fn($c) => $c["ativo"]===true);
//novo array , tera apenas os clientes que a chave ativo for igual a true
```

- `array_map`
Serve para alterar Todos os dados de um array de uma única vez

```php
$produtos = [
    ["id"=>1, "preco"=10.00, "setor"=>"jardim"],
    ["id"=>2, "preco"=15.90, "setor"=>"ferramenta"],
    ["id"=>3, "preco"=23.50, "setor"=>"jardim"],
]
//ajustar o preço de todos os produtos em 10% de aumento

$produtosAjustados = array_map(fn($p) => $p["preco"] = $p["preco"]*1.1, $produtos);

```

















