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


---

# LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA – Controllers e Routes no Laravel

## Parte A – Questões Teóricas de Fixação

**1. Semântica RESTful:**  
Uma ação de exclusão de dados nunca deve ser implementada via requisição HTTP `GET` porque, pela especificação HTTP/REST, o método `GET` deve ser **seguro** e **somente leitura** (não deve alterar estado no servidor). Se uma rota `GET` apagar registros, mecanismos automáticos que apenas "visitam" links — como robôs de busca (crawlers), pré-carregamento de abas/links do navegador (prefetching) ou extensões — podem acionar essa URL ao rastrear a página e excluir dados acidentalmente sem intenção do usuário.

**2. Idempotência:**  
No protocolo HTTP, idempotência significa que executar a mesma requisição uma única vez ou várias vezes seguidas produz exatamente o **mesmo estado final** no servidor (sem efeitos colaterais duplicados).  
- O **`PUT`** é idempotente porque substitui/atualiza o recurso inteiro na URL alvo com os mesmos dados enviados: repetir o mesmo `PUT` mantém o registro com o mesmo estado final.  
- O **`POST`** não é idempotente porque normalmente cria um novo recurso a cada envio: repetir o mesmo `POST` gera múltiplos registros duplicados (com IDs diferentes).

**3. Resource Controllers:**  
As 7 ações canônicas geradas por `php artisan make:controller --resource` e suas responsabilidades são:
1. `index()` (`GET /recurso`): listar todos os registros do recurso.
2. `create()` (`GET /recurso/create`): exibir o formulário HTML de criação.
3. `store(Request $request)` (`POST /recurso`): validar e gravar um novo registro no banco.
4. `show($id)` (`GET /recurso/{id}`): exibir os detalhes de um registro específico.
5. `edit($id)` (`GET /recurso/{id}/edit`): exibir o formulário HTML de edição preenchido com os dados atuais.
6. `update(Request $request, $id)` (`PUT/PATCH /recurso/{id}`): validar e atualizar um registro existente.
7. `destroy($id)` (`DELETE /recurso/{id}`): remover um registro específico.

**4. Injeção de Dependências:**  
O **Service Container** do Laravel analisa os parâmetros e tipos declarados (type-hinting) na assinatura do método do controller via Reflection do PHP antes de executá-lo. Ao detectar o parâmetro `Request $request`, o container resolve automaticamente a instância atual da requisição HTTP (`Illuminate\Http\Request`) e a entrega pronta ao método, dispensando `new Request()`.

**5. Method Spoofing:**  
Os navegadores web suportam nativamente apenas os métodos `GET` e `POST` no atributo `method` de formulários HTML (`<form>`). Para contornar essa limitação, o Laravel utiliza a técnica de **Method Spoofing**: o formulário envia uma requisição `POST` contendo um campo oculto `_method` (gerado pela diretiva Blade `@method('PUT')`, `@method('PATCH')` ou `@method('DELETE')`). Ao receber a requisição, o framework lê `_method` e a direciona para a rota correspondente ao verbo semântico simulado.

**6. Ataques CSRF:**  
Cross-Site Request Forgery (CSRF) é um ataque em que um site malicioso induz o navegador de um usuário já autenticado a enviar requisições indesejadas para uma aplicação confiável, aproveitando os cookies de sessão ativos. A diretiva Blade `@csrf` insere um campo oculto (`_token`) com um token criptográfico aleatório associado à sessão do usuário; o middleware `VerifyCsrfToken` compara o token enviado com o da sessão e bloqueia requisições forjadas sem token válido retornando erro `419 Page Expired`.

**7. Constraints de Rota:**  
Métodos como `whereNumber('id')` e `whereAlphaNumeric('codigo')` restringem por expressão regular o formato aceito nos parâmetros dinâmicos da URL antes mesmo de acionar o controller. Quando o formato é violado, a rota não casa com a requisição e o Laravel retorna automaticamente o status HTTP **`404 Not Found`**.

**8. Rotas Nomeadas:**  
Duas vantagens corporativas de usar `route('clientes.show', $id)` em vez de strings estáticas como `"/clientes/{$id}"`:
1. **Manutenibilidade e refatoração centralizada:** se o caminho da URL mudar em `routes/web.php` (por exemplo, de `/clientes` para `/parceiros`), todas as views continuam funcionando sem precisar alterar links espalhados pelo projeto.
2. **Prevenção de erros e integridade de parâmetros:** caso uma rota nomeada não exista ou falte um parâmetro obrigatório, o Laravel acusa o erro explicitamente durante a renderização/testes, evitando links quebrados silenciosos em produção.

**9. Single Responsibility no Controller:**  
Manter a validação enxuta com `$request->validate()` ou isolada em **Form Requests** mantém o método do controller focado exclusivamente em orquestrar a requisição HTTP (validar entrada, acionar persistência/serviço e devolver resposta). Isso evita métodos longos com dezenas de regras condicionais espalhadas, facilita a leitura, permite reutilização de regras e garante o respeito ao limite de 20 linhas por função.

**10. A Ferramenta `route:list`:**  
O comando `php artisan route:list` exibe uma matriz consolidada com todos os métodos HTTP, URIs, nomes de rota, controllers/ações e middlewares ativos da aplicação. Isso permite que equipes multidisciplinares (backend, frontend, QA e segurança) auditem endpoints expostos, validem prefixos/middlewares e consultem rapidamente contratos de rotas sem ler todo o código-fonte.

---

## Parte B – Exercícios Práticos de Laboratório (Módulo Clientes e Fornecedores)

**Implementações adicionadas ao projeto `senai-asset-manager`:**
- **Exercício 1 (`GET /clientes/{cliente}/contratos/{ano}`):** rota com `whereNumber('cliente')` e `where('ano', '[0-9]{4}')` ligada a `ClienteController::contratosPorAno(int $cliente, int $ano)`.
- **Exercício 2 (`FornecedorController` parcial):** `Route::resource('fornecedores', FornecedorController::class)->parameters(['fornecedores' => 'fornecedor'])->only(['index', 'show'])` validado com `php artisan route:list --path=fornecedores`.
- **Exercício 3 (`GET /clientes/telemetria/origem`):** `ClienteController::origemRequisicao(Request $request)` retorna JSON com `$request->ip()` e `$request->userAgent()`.
- **Exercício 4 (`GET /admin/auditoria/clientes`):** grupo com prefixo `/admin`, nome `admin.` e middleware `AuditoriaAdminMiddleware`, apontando para `ClienteController::auditoriaAtivos()` (`route('admin.auditoria.clientes')`).
- **Exercício 5 (`PATCH /clientes/{id}/status`):** `ClienteController::alterarStatus(Request $request, int $id)` alterna o status entre `ATIVO` e `SUSPENSO`, com botão rápido na tabela de `resources/views/clientes/index.blade.php` usando `@csrf` e `@method('PATCH')`.
- **CRUD Completo de Clientes:** `ClienteController` gerado via `php artisan make:controller ClienteController --resource`, Model `Cliente` + migration `create_clientes_table`, seeder `ClienteSeeder` e views Blade (`index`, `create`, `edit`, `show`) com `@csrf`, `@method('PUT')`, `@method('DELETE')` e helper `route(...)`.
