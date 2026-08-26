***Lista de Exercícios: Funções em PHP***
Data `21.08.2026`

---

***Parte A***

***Conceito de função***

Uma função é um bloco de código criado para realizar uma determinada tarefa. Em vez de escrever o mesmo código várias vezes, podemos criar uma função uma vez e chamá-la sempre que precisarmos.

Por exemplo, podemos criar uma função para calcular um preço.

Ela é muito importante pois vai ajudar na:
  - Organização: o programa fica dividido em partes menores e mais fáceis de entender.
  - Reutilização: podemos utilizar a mesma função várias vezes sem precisar escrever o mesmo código novamente.

> **No PHP, uma função é criada utilizando a palavra-chave function**

Afinal ninguem merece ficar dando ctrl c + cntl v a vida toda né. Ajilisa o proceso kksks.

---

***Princípio DRY***

 ***DRY significa "Don't Repeat Yourself", ou seja, "Não se repita***

Repetir o mesmo bloco de código em várias partes do sistema pode causar `problemas` porque, se precisarmos fazer uma alteração, teremos que procurar e modificar todas as cópias daquele código. Se esquecermos alguma, o programa pode apresentar comportamentos diferentes em lugares diferentes.

Exemplo:

Em vez de escrever o cálculo de desconto várias vezes, podemos criar:

```php
function calcularDesconto(float $preco): float {
    return $preco * 0.90;
}

```

> Assim, sempre que precisarmos calcular o desconto, basta chamar calcularDesconto().

---

*****Parâmetros e retorno*****

Parâmetro é uma informação que a função recebe para conseguir realizar sua tarefa

Valor retornado é o resultado que a função devolve depois de realizar seu trabalho. No PHP, isso é feito utilizando return.

Na função:

```php
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}

```

>Temos: 
  - $preco → parâmetro do tipo float.
  - $quantidade → parâmetro do tipo int.
  - float → indica que a função deve retornar um valor do tipo float.
  - return $preco * $quantidade → calcula e devolve o resultado.

Por exemplo:

calcularTotal(10.50, 3);

A função recebe 10,50 como preço e 3 como quantidade e retorna 31,50.

>Obs: Muito importante e utilizado pra tudo (não esquece sofia!)

---

***Tipagem***
Na declaração:
function cadastrar(string $nome, int $idade): bool

Cada elemento significa:

|elemento| significado |
|---|---|
| function | Indica que estamos criando uma função |
| cadastrar | Nome da função |
| string | Tipo do parâmetro $nome |
| $nome |  Parâmetro que recebe o nome |
| int | Tipo do parâmetro $idade |
| $idade |  Parâmetro que recebe a idade |
| bool | Tipo do valor que a função deve retornar |

***Então, resumindo:***

A função cadastrar recebe um nome como string e uma idade como int, e deve retornar um valor bool, que pode ser true ou false.

---

***void e return***

Uma função que retorna string devolve um texto para quem chamou a função.

Exemplo:

```php
function saudacao(): string {
    return "Olá, Sofia!";
}
```

Nesse caso, a função retorna uma string.

Já uma função void é utilizada quando a função não deve retornar um valor.

Exemplo:

```php

function mostrarMensagem(): void {
    echo "Olá!";
}

```

Aqui, a função apenas executa uma ação: mostra uma mensagem.

Uma diferença importante é que return pode encerrar a execução da função e devolver um valor para o local onde ela foi chamada

---

***Escopo***
Escopo é o lugar onde uma variável pode ser usada no código. O escopo global permite usar a variável em várias partes do programa, enquanto o escopo local permite usá-la apenas dentro de uma função ou parte específica do código.

---

***Referência***
Quando usamos `&` antes de um parâmetro, a função pode `alterar diretamente a variável original`. Sem o &, a função trabalha apenas com o valor recebido e a variável original não é modificada. Portanto, a referência permite que as alterações feitas dentro da função também aconteçam na variável que foi enviada para ela.

---

***Funções nativas***

Funções nativas são funções que já vêm prontas no PHP e podem ser utilizadas para realizar tarefas específicas. 

Algumas delas que o professor explicou são as : 
 - `strlen`, que conta o tamanho de um texto;
 -  `strtoupper`, que transforma um texto em letras maiúsculas; 
 - `strtolower`, que transforma um texto em letras minúsculas;
 -  `count`, que conta elementos de um array;
 - `str_replace`, que substitui uma parte de um texto por outra. Essas funções recebem determinados parâmetros e retornam um resultado de acordo com a tarefa realizada.

 ---

***Previsão de saída***

A função recebe o valor de 100 e calcula 90% dele, resultando em 90. Depois, o programa mostra novamente o valor da variável $valor, que continua sendo 100, pois a função não alterou a variável original. Como os dois echo estão juntos e não existe espaço ou quebra de linha entre eles, o resultado exibido será 90100.

---

***Documentação***

De acordo com a documentação oficial do PHP, a função strlen() é utilizada para descobrir o tamanho de uma string. Ela recebe uma string como parâmetro e retorna um número inteiro (int) indicando o seu tamanho em bytes.

Sintaxe: strlen(string $string): int

Documentação oficial do PHP — strlen()



