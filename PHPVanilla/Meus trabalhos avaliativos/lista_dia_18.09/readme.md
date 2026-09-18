### 1. Conceituação OWASP

XSS significa Cross-Site Scripting e é uma vulnerabilidade que permite que um atacante insira códigos maliciosos em uma página da internet. Ela é considerada uma vulnerabilidade do lado do cliente porque o código acaba sendo executado no navegador da pessoa que acessa a página. `Mesmo assim, o Back-End precisa ajudar a prevenir esse problema, tratando corretamente os dados recebidos dos usuários e escapando as informações antes de colocá-las no HTML.`

### 2. Reflected vs Stored

O XSS Refletido acontece quando o código malicioso é enviado para a aplicação, geralmente por meio de uma URL ou formulário, e é devolvido imediatamente na resposta da página. Já o `XSS Stored,` também chamado de `XSS Gravado,` acontece quando o conteúdo malicioso é armazenado pela aplicação, como em um banco de dados ou arquivo, e depois é exibido para outros usuários. O Stored pode ter um potencial maior de impacto porque o conteúdo fica salvo no sistema e pode atingir várias pessoas que acessarem a informação contaminada.

### 3. Mecanismo de Escapamento

A função htmlspecialchars() transforma alguns caracteres especiais em entidades HTML. Por exemplo, o caractere menor que (<) é transformado em < e o caractere maior que (>) é transformado em >. Dessa forma, se uma pessoa tentar inserir uma tag HTML ou um código JavaScript, o navegador entende esses caracteres como texto e não como uma tag que deve ser executada. Por isso, um código como uma tag script não será executado quando estiver corretamente escapado.

### 4. Flags de Proteção

A flag ENT_QUOTES faz com que a função htmlspecialchars() também transforme aspas simples e aspas duplas em entidades HTML. Isso é importante principalmente quando uma informação do usuário é colocada dentro de atributos HTML, como o atributo value de um input. Se as aspas não forem tratadas corretamente, um atacante poderia tentar fechar o atributo antes da hora e inserir outros elementos HTML ou códigos maliciosos na página.

### 5. Anti-Alucinação PHP

Não devemos utilizar FILTER_SANITIZE_STRING em projetos modernos porque esse filtro foi descontinuado no PHP 8.1 e não deve ser usado em versões atuais do PHP, como o PHP 8.3. Além disso, sanitizar uma informação de forma genérica não substitui a validação correta dos dados. O ideal é validar cada informação de acordo com o formato esperado e realizar o escapamento adequado quando ela for exibida.

### 6. Validação de E-mail

A função empty() serve apenas para verificar se uma variável está vazia ou possui um valor considerado vazio. Ela não verifica se o conteúdo possui formato de e-mail. Já a função filter_var() usando FILTER_VALIDATE_EMAIL verifica se o valor possui um formato válido de endereço de e-mail. Portanto, empty() pode ser utilizada para verificar se o campo foi preenchido, enquanto FILTER_VALIDATE_EMAIL é usada para verificar se o conteúdo realmente parece ser um e-mail válido.

### 7. Roubo de Sessão

Uma vulnerabilidade XSS pode permitir que um atacante execute JavaScript dentro da página acessada por um usuário. Dependendo da configuração dos cookies da aplicação, esse código poderia tentar acessar informações relacionadas à sessão do usuário e utilizá-las para tentar se passar por ele. Uma das formas de aumentar a proteção é utilizar cookies de sessão com a configuração HttpOnly, que impede o acesso ao cookie por JavaScript.

### 8. Segurança em Camadas

Sanitizar os dados na entrada, por exemplo usando strip_tags(), não elimina a necessidade de escapar os dados na saída. Isso acontece porque o mesmo dado pode ser utilizado em diferentes partes da aplicação e nem sempre o tratamento feito na entrada é suficiente para todos os contextos. Por isso, é importante validar os dados recebidos e, quando eles forem exibidos no HTML, utilizar htmlspecialchars() com ENT_QUOTES. Dessa forma, a aplicação trabalha com diferentes camadas de proteção contra ataques como XSS.
