## Parte A – Questões Teóricas
**1. Evolução Arquitetural:**

A construção do MVC artesanal na Semana 12 ajudou a entender melhor como organizar um projeto, separando as responsabilidades entre Models, Views e Controllers. Com isso, consegui compreender como cada parte funciona e como o Laravel utiliza essa mesma organização, mas de uma forma mais automatizada, organizada e profissional.

**2. A Nova Arquitetura do Laravel 11:**

No Laravel 11, a estrutura de inicialização foi simplificada em comparação com as versões 9 e 10. Várias configurações que antes ficavam espalhadas em diferentes arquivos passaram a ser centralizadas no arquivo `bootstrap/app.php`, que se tornou o principal ponto de configuração da aplicação.

**3. Padrão 12-Factor App:**

Colocar senhas do banco de dados diretamente no arquivo `config/database.php` é uma falha de segurança, pois essas informações podem acabar expostas quando o projeto é compartilhado ou enviado para o GitHub. O correto é utilizar o arquivo `.env`, que mantém as informações sensíveis separadas do código-fonte e facilita a configuração de cada ambiente.

**4. O Papel da APP_KEY:**

Alterar a `APP_KEY` de uma aplicação que já está em produção pode causar problemas, pois ela é utilizada para criptografar informações importantes. Se for modificada, dados que foram criptografados anteriormente podem não ser mais reconhecidos, como cookies e sessões dos usuários, causando perda de acesso e outros problemas no sistema.

**5. Isolamento de Diretórios:**

O servidor web deve apontar somente para a pasta `public/` porque ela contém os arquivos que podem ser acessados pelos visitantes, como o `index.php`, CSS e JavaScript. Isso protege os arquivos internos do Laravel, evitando que informações importantes, como configurações, senhas e códigos da aplicação, fiquem expostas na internet.

**6. Artisan CLI:**

A diferença é que o comando `php arquivo.php` executa diretamente um arquivo PHP específico, enquanto o `php artisan` utiliza uma ferramenta própria do Laravel para executar tarefas administrativas e de desenvolvimento. Com ele, podemos criar controllers, models, migrations, limpar caches e executar outras operações de maneira mais rápida e organizada.

**7. O Arquivo .env.example:**

Manter o `.env.example` atualizado é importante porque ele serve como um modelo de configuração para outros desenvolvedores que precisam executar o projeto. Como o arquivo `.env` normalmente não é enviado para o Git por questões de segurança, o exemplo permite que todos saibam quais variáveis precisam configurar para fazer a aplicação funcionar corretamente.

**8. Motor de Templates Blade:**

A diretiva `{{ $variavel }}` exibe o conteúdo com escape automático de caracteres especiais, ajudando a proteger a aplicação contra ataques XSS. Já a diretiva `{!! $variavel !!}` exibe o conteúdo sem esse tratamento, permitindo a interpretação de HTML. Por isso, deve ser utilizada com muito cuidado, somente quando o conteúdo for confiável e seguro.

**9. Responsabilidade do Controller:**

Um Controller deve ter métodos curtos porque sua principal responsabilidade é receber as requisições, chamar as funcionalidades necessárias e retornar uma resposta. Consultas SQL e regras de negócio extensas devem ficar em classes específicas, como Models e Services. Essa organização facilita a manutenção, os testes e evita que o código fique confuso e difícil de entender.

**10. A Ferramenta Tinker:**

O `php artisan tinker` é uma ferramenta que permite executar comandos PHP e testar funcionalidades do Laravel diretamente pelo terminal, sem precisar criar arquivos específicos para cada teste. Ele ajuda a verificar Models, consultar registros do banco de dados, testar funções e conferir se determinadas operações estão funcionando corretamente, economizando tempo durante o desenvolvimento.

## Parte B - Senai Asset Manager (Exercicios Praticos de Laboratorio)

Este projeto contem as solucoes da Parte B do laboratorio, desenvolvidas em Laravel 11 com tipagem rigorosa, funcoes curtas (<= 20 linhas) e comentarios em portugues do Brasil (pt-BR).

**Endpoints implementados:**
- `GET /setores` (nome: `ativos.setores`) - telemetria dos setores fabris (Exercicio 1)
- `GET /ativos/{codigo}` - detalhes tecnicos do ativo com validacao `PAT-001` (Exercicio 3)
- `GET /healthz` - health check com status, uptime e memoria (Exercicio 5)

**Comando artisan:**
- `php artisan senai:status` - nome da plataforma, ambiente ativo e total de ativos operacionais (Exercicio 2)

**Arquivos principais:**
- `app/Http/Controllers/AtivoController.php` - metodos `setores()`, `detalhar()` e `saude()`
- `app/Models/Ativo.php` - modelo de ativo de producao
- `routes/web.php` - rotas da aplicacao
- `routes/console.php` - comando `senai:status`

A documentacao detalhada de cada exercicio, com saidas reais e o checklist de qualidade, encontra-se no `readme.md` da raiz do repositorio.
