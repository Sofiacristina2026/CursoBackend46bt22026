Parte A: Questões Teóricas de Fixação
1. O Colapso do Código Espaguete:

Porque misturar SQL, validações e HTML no mesmo arquivo deixa o código desorganizado, difícil de entender, corrigir e atualizar. Separar essas partes facilita a manutenção e o crescimento do sistema.

2. A Tríade MVC:
- Model: Cuida dos dados e das regras de negócio.
- View: É responsável pela parte visual do sistema (HTML).
- Controller: Recebe as requisições e conecta o Model com a View.
As regras de negócio devem ficar no Model.

3. O Papel do Composer:

O composer.json define as dependências do projeto, enquanto o composer.lock registra as versões exatas instaladas. A pasta vendor/ não deve ser enviada ao Git porque pode ser recriada pelo Composer, evitando arquivos desnecessários no repositório.

4. A Especificação PSR-4:

O PSR-4 utiliza o namespace para localizar automaticamente os arquivos. Assim, o namespace App\Controllers é relacionado à pasta src/Controllers, encontrando o arquivo ProdutoController.php.

5. Front Controller:

A principal vantagem é a segurança, pois centraliza as requisições no arquivo public/index.php e impede o acesso direto aos arquivos internos do projeto.

6. Roteador HTTP:

Ele verifica o método HTTP e a URL da requisição. Assim, diferencia o GET, usado para consultar produtos, do POST, usado para cadastrar produtos.

7. Injeção de Dados na View:

A função extract() transforma os dados de um array em variáveis PHP, permitindo que a View utilize essas informações diretamente.

8. Segurança contra XSS nas Views:

Porque htmlspecialchars() transforma caracteres especiais em entidades HTML, evitando que códigos maliciosos sejam executados na página.

9. Single Responsibility no Controller:

Porque o Controller deve apenas controlar o fluxo das requisições. As consultas SQL e conexões com o banco devem ficar em classes responsáveis por essa função, deixando o código mais organizado e fácil de manter.

10. Transição para o Framework Laravel:

Os conceitos são MVC, rotas, Controllers, Models, Views, autoload PSR-4, Composer, separação de responsabilidades e segurança nas requisições. O Laravel utiliza esses mesmos princípios, mas oferece ferramentas prontas para facilitar o desenvolvimento.