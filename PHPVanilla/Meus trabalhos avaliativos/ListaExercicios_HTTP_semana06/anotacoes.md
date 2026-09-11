### Parte A ###
---

1. 
A principal diferença ENTRE O USO DO get  E POST está em onde os dados são enviados.
No método GET, os dados ficam anexados à própria URL do navegador, depois do ?. Por isso, eles podem aparecer na barra de endereço e ficar visíveis.

No método POST, os dados são enviados dentro do corpo da requisição HTTP, e não aparecem na URL. 

Pra ficar mais facíl eu penso que o GET é parar os dados URL e o post só o corpo da requisição mesmo.

---

2. Por que não devemos enviar senhas com GET?

Porque os dados enviados por GET aparecem na URL.
Isso é perigoso porque a URL pode ficar registrada em lugares.
Além disso, a URL pode ser copiada ou compartilhada sem perceber.
Por isso, informações sensíveis, como senhas, devem ser enviadas usando POST.
Por exemplo eu entro em um site e eu coloco a minha senha ela caba ficando salva na URL se alguém ver eu vou ser alvo fácil. Ficaria maios omenos assim:

> site.com/login?senha=123456

---

3. O que é Coalescência Nula ?

A coalescência nula é um operador lógico representado por ?? em várias linguagens de programação que retorna o valor da direita se o valor da esquerda for nulo ou indefinido

Basicamente, o ?? serve pra falar:

> “Se tiver alguma coisa aqui, usa ela. Se não tiver (null), usa essa outra coisa.”

Por exemplo:

```PHP
$nome = null;

echo $nome ?? "Nome não informado";
```

> Aqui o PHP pensa:
 “O $nome tem alguma coisa?” Não. Ele está null.
Então ele pega o que está depois do ??:

Resultado: Nome não informado

Agora olha:

```php
$nome = "Sofia";
```

echo $nome ?? "Nome não informado";

O PHP pensa:

> “O $nome tem um valor?”

Tem! Então ele usa Sofia e ignora o "Nome não informado".

Resultado:

> Sofia 

“Pra ficar mais facíl se não tiver isso, usa isso aqui.”

$nome ?? "Nome não informado"

É praticamente:

“Se $nome estiver vazio/nulo, coloca Nome não informado.”

---

4. O que significa GET ser idempotente?

Uma requisição GET é considerada idempotente quando fazer a mesma requisição várias vezes não deveria causar uma mudança diferente no estado do sistema.
Por exemplo, pesquisar um produto várias vezes não deveria alterar o banco.
Por isso, usar links GET para deletar ou alterar informações é uma má prática.

Por exemplo:

> site.com/deletar.php?id=5

Se alguém acessar esse link novamente, a ação pode ser executada novamente.

> obs: GET deve ser usado principalmente para consultar/buscar informações, não para ações destrutivas.

---

5. required e type="email" deixam o formulário 100% seguro?

Sendo sincero não, ele ajuda sim a proteger mais não é 100% Essas validações acontecem no navegador, ou seja, no lado do cliente (client-side).
O usuário pode desativar o HTML5, alterar a requisição ou enviar dados diretamente para o servidor.
Por isso, o PHP também precisa validar os dados.

Mas mesmo asism os dois podem ajudar bastnate o Client-side (ajuda o usuário e melhora a experiência). E Server-side (é essencial para garantir que os dados recebidos sejam válidos.)
É muito importante não confiar somente no HTML.

---

6. O risco de não usar htmlspecialchars()

Se colocarmos diretamente na página um dado recebido pelo usuário:

```PHP
echo $_POST['nome'];
```

Alguém poderia enviar código HTML ou JavaScript em vez de um simples nome.

Isso pode causar um ataque chamado XSS (Cross-Site Scripting).

Por isso usamos:

echo htmlspecialchars($_POST['nome']);

O htmlspecialchars() transforma caracteres especiais em uma forma segura para serem exibidos na página.

---

7. O que é a técnica de Sticky Forms e qual é o seu impacto na experiência do usuário (UX)?

A técnica de Sticky Forms (ou "formulários colantes", em tradução livre) consiste em manter os dados preenchidos pelo usuário salvos no formulário caso ocorra um erro de validação ou a página precise ser recarregada. Em vez de limpar todos os campos e forçar a pessoa a digitar tudo novamente, o sistema preserva o que já foi inserido e apenas destaca os campos que precisam de correção.No desenvolvimento web básico, isso geralmente é feito capturando os valores enviados (via métodos como POST ou GET) e reinserindo-os nos atributos value dos campos de entrada HTML.

---

8. Como você utilizaria a aba Network do navegador para comprovar que um formulário foi enviado via POST e não via GET?
 
Para comprovar que um formulário foi enviado via POST e não via GET, você deve abrir a aba Network (Rede) das ferramentas de desenvolvedor do navegador (F12) antes de enviar o formulário e analisar a linha de requisição gerada
---
