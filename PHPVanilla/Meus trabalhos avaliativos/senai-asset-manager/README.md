# SENAI Supply — Sistema de Estoque

Sistema de gerenciamento de estoque para a fábrica do SENAI. Feito em PHP com arquitetura MVC, login seguro, controle de quem pode fazer o quê (RBAC), estoque com transação segura e registro de tudo em um arquivo de log.

---

## O que o sistema faz

- **Login e logout**: senhas são guardadas de forma segura (BCrypt, nunca em texto puro).
- **Permissões (RBAC)**: existem três perfis — admin, gestor e almoxarife. Cada um pode acessar apenas o que tem permissão. Quem não tem acesso recebe erro 403.
- **Estoque seguro**: entradas e saídas usam transação ACID. Se não tiver produto suficiente, a saída é desfeita (rollback) e o estoque não fica negativo.
- **Log de auditoria**: tudo que acontece no sistema fica gravado em `logs/app.log` com data, hora, IP, tipo de aviso e detalhes.
- **Proteção contra ataques**: CSRF em formulários, senha de sessão regenerada no login, variáveis escapadas nas telas (contra XSS) e consultas preparadas no banco (contra SQL Injection).

---

## Como é organizada a pasta

```
senai-asset-manager/
├── public/
│   └── index.php          # Único ponto de entrada (Front Controller)
├── src/
│   ├── Core/              # Coração do sistema (banco, logger, guard, roteador, csrf)
│   ├── Models/            # Regras de negócio (usuário, produto, movimentação)
│   ├── Controllers/       # Controladores (login, painel, produtos, estoque)
│   └── Views/             # Telas HTML (login, painel, catálogo, entrada/saída)
├── database/
│   └── schema.sql         # Script para criar o banco no PostgreSQL
├── logs/
│   └── app.log            # Arquivo de auditoria (criado automaticamente)
├── vendor/                # Gerado pelo Composer (não enviar ao Git)
├── .env                   # Configurações (não enviar ao Git)
├── .env.example           # Exemplo de configurações
├── composer.json          # Dependências e autoload PSR-4
└── README.md
```

---

## Como instalar e rodar

### 1. Baixe o projeto
Copie a pasta do projeto para o seu computador.

### 2. Configure o banco de dados
Você precisa do PostgreSQL instalado.

Crie um banco chamado `senai_supply` e rode o script:

```bash
psql -U postgres -d senai_supply -f database/schema.sql
```

Isso cria as tabelas `usuarios`, `produtos` e `movimentacoes_estoque`, e cadastra 3 usuários de teste:

| E-mail | Senha | Perfil |
|--------|-------|--------|
| admin@senai.local | admin123 | admin |
| gestor@senai.local | gestor123 | gestor |
| almoxarife@senai.local | almox123 | almoxarife |

### 3. Instale as dependências
No terminal, dentro da pasta do projeto:

```bash
composer dump-autoload -o
```

Isso prepara o carregamento automático das classes (PSR-4).

### 4. Ajuste as configurações
Copie o arquivo de exemplo:

```bash
cp .env.example .env
```

Abra o `.env` e coloque a senha do seu PostgreSQL em `DB_PASSWORD`.

### 5. Inicie o servidor
```bash
php -S localhost:8000 -t public
```

Acesse no navegador: `http://localhost:8000`

---

## Telas do sistema

- **`/login`** — Entrar no sistema (público)
- **`/dashboard`** — Painel com resumo do estoque (qualquer usuário logado)
- **`/produtos`** — Catálogo de produtos (gestor, almoxarife, admin)
- **`/movimentacoes`** — Histórico de entradas e saídas (gestor, almoxarife, admin)
- **`/movimentacoes/entrada`** — Registrar entrada de produto
- **`/movimentacoes/saida`** — Registrar saída de produto
- **`/logout`** — Sair do sistema

---

## Segurança em resumo

- Senhas com `password_hash()` (BCrypt) e verificadas com `password_verify()`.
- Sessão regenerada ao logar (`session_regenerate_id`).
- Token CSRF em todo formulário POST.
- Todas as palavras mostradas na tela usam `htmlspecialchars()` (contra XSS).
- Consultas ao banco usam `PDO` com prepared statements (contra SQL Injection).
- Guards RBAC bloqueiam acesso indevido com HTTP 403.
- Logs gravados com trava atômica (`LOCK_EX`) fora da pasta pública.

---

## Logs de auditoria

Tudo fica registrado em `logs/app.log`, fora da pasta pública. Cada linha tem:
- Data e hora
- Nível (INFO, AVISO, ERRO)
- IP do usuário
- Mensagem
- Contexto em JSON

---

## Créditos
Projeto desenvolvido para a unidade curricular de Programação Back-End (1º Semestre), Semana 12 — Arquitetura MVC Artesanal, RBAC e Auditoria.
