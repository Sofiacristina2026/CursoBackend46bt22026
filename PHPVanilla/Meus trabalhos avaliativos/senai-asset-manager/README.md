Parte A – Questões teóricas
1. Evolução Arquitetural

Na construção do MVC artesanal, aprendi a separar as responsabilidades do sistema entre Model, View e Controller. Isso facilitou a compreensão do Laravel, pois ele utiliza essa mesma organização, mas oferece ferramentas prontas para facilitar o desenvolvimento e a manutenção do código.

2. A Nova Arquitetura do Laravel 11

No Laravel 11, a estrutura foi simplificada em relação às versões anteriores. O arquivo bootstrap/app.php passou a ser o ponto central de inicialização e configuração da aplicação, reunindo configurações que antes ficavam distribuídas em vários arquivos.

3. Padrão 12-Factor App

Gravar senhas diretamente no arquivo config/database.php é um risco porque as credenciais podem ser expostas quando o código é compartilhado pelo Git. O arquivo .env permite armazenar essas informações separadamente, protegendo os dados de acesso ao banco.

4. O Papel da APP_KEY

Alterar a APP_KEY de uma aplicação em produção pode causar problemas na descriptografia de dados que foram protegidos com a chave antiga, como cookies e sessões. Isso pode fazer com que usuários percam suas sessões e dados criptografados deixem de ser acessíveis.

5. Isolamento de Diretórios

O servidor deve apontar somente para a pasta public/ porque ela contém os arquivos que podem ser acessados publicamente. Isso protege arquivos internos do projeto, como configurações, credenciais, código-fonte e o arquivo .env.

6. Artisan CLI

O comando php arquivo.php executa diretamente um arquivo PHP. Já o php artisan utiliza uma ferramenta própria do Laravel que oferece comandos para criar arquivos, executar migrações, iniciar o servidor e administrar a aplicação.

7. O Arquivo .env.example

O .env.example serve como modelo de configuração para outros desenvolvedores. Mantê-lo atualizado facilita a instalação do projeto em outros computadores, pois informa quais variáveis de ambiente precisam ser configuradas, sem expor senhas reais.

8. Motor de Templates Blade

A diretiva {{ $variavel }} realiza o escape automático do conteúdo, ajudando a prevenir ataques XSS. Já {!! $variavel !!} exibe o conteúdo sem esse tratamento, podendo permitir a execução de códigos HTML ou JavaScript maliciosos.

9. Responsabilidade do Controller

Um Controller deve ter métodos curtos para facilitar a leitura, manutenção e organização do sistema. As consultas ao banco e as regras de negócio devem ficar em suas respectivas camadas, evitando que o Controller acumule muitas responsabilidades.

10. A Ferramenta Tinker

O comando php artisan tinker abre um terminal interativo para executar comandos PHP dentro do ambiente Laravel. Ele permite testar modelos, consultar configurações, criar objetos e verificar resultados sem precisar criar um arquivo PHP para cada teste.

#### Para começar o código
### Passo 1 – Acessar a pasta de trabalhos
Primeiramente, abri o terminal do VS Code e naveguei até a pasta onde ficam armazenados meus trabalhos de PHP.
Utilizei o comando:

```php
cd ..
```
Esse comando permitiu voltar um diretório para acessar a localização correta do projeto.

### Passo 2 – Verificar o Composer
Utilizei o comando:

```powershell
composer --version
```
O objetivo foi verificar se o Composer estava instalado e disponível no terminal.

### Passo 3 – Criar o projeto Laravel 11
Executei o comando:

```powershell
composer create-project laravel/laravel senai-asset-manager "^11.0"
```

Esse comando realiza o download e a criação de uma aplicação utilizando o Laravel na versão 11.

### Passo 4 – Acessar a pasta do projeto
Depois da criação, entrei na pasta utilizando:

```powershell
cd senai-asset-manager
```

### Passo 5 – Instalar as dependências
Executei:

```powershell
composer install
```

Esse comando instalou td que eu precisava para o funcionamento do Laravel, criando a pasta `vendor` e o arquivo `vendor/autoload.php`.

### Passo 6 – Verificar a instalação
Para verificar se a aplicação estava funcionando corretamente, executei:

```php
php artisan about
```
Esse comando apresenta informações sobre a aplicação, incluindo sua versão, ambiente e configurações.

### Passo 7 – Iniciar o servidor local
Por último, utilizei:

```powershell
php artisan serve
```
Esse comando inicia um servidor local para permitir o acesso à aplicação pelo navegador.

## 2. Passo a passo da instalação

### Passo 1 – Acessar a pasta de trabalhos

Primeiramente, abri o terminal do VS Code e naveguei até a pasta onde ficam armazenados meus trabalhos de PHP.

Utilizei o comando:

```powershell
cd ..
```

Esse comando permitiu voltar um diretório para acessar a localização correta do projeto.

### Passo 2 – Verificar o Composer

Utilizei o comando:

```powershell
composer --version
```

O objetivo foi verificar se o Composer estava instalado e disponível no terminal.

O Composer é uma ferramenta responsável por gerenciar as dependências e bibliotecas utilizadas em projetos PHP.

### Passo 3 – Criar o projeto Laravel 11

Executei o comando:

```powershell
composer create-project laravel/laravel senai-asset-manager "^11.0"
```

Esse comando realiza o download e a criação de uma aplicação utilizando o Laravel na versão 11.

### Passo 4 – Acessar a pasta do projeto

Depois da criação, entrei na pasta utilizando:

```powershell
cd senai-asset-manager
```

### Passo 5 – Instalar as dependências

Executei:

```powershell
composer install
```

Esse comando instalou as bibliotecas necessárias para o funcionamento do Laravel, criando a pasta `vendor` e o arquivo `vendor/autoload.php`.

### Passo 6 – Verificar a instalação

Para verificar se a aplicação estava funcionando corretamente, executei:

```powershell
php artisan about
```

Esse comando apresenta informações sobre a aplicação, incluindo sua versão, ambiente e configurações.

### Passo 7 – Iniciar o servidor local

Por último, utilizei:

```powershell
php artisan serve
```

Esse comando inicia um servidor local para permitir o acesso à aplicação pelo navegador.

## 3. Erros encontrados e soluções

### Erro 1 – Arquivo Artisan não encontrado

**Mensagem apresentada:**

```text
Could not open input file: artisan
```

**Motivo:**

O terminal estava em uma pasta que não continha a estrutura completa de um projeto Laravel. Inicialmente, a pasta possuía apenas o arquivo `readme.md`.

**Solução:**

Foi necessário criar a aplicação Laravel 11 utilizando o Composer e acessar a pasta correta do projeto.

### Erro 2 – Arquivo vendor/autoload.php não encontrado

**Mensagem apresentada:**

```text
Failed opening required 'vendor/autoload.php'
```

**Motivo:**

O arquivo `artisan` já existia, porém as dependências do projeto ainda não estavam instaladas corretamente. Por isso, o Laravel não conseguia localizar o arquivo responsável pelo carregamento automático das bibliotecas.

**Solução:**

Executei o comando:

```powershell
composer install
```

Após a instalação das dependências, o arquivo `vendor/autoload.php` foi disponibilizado e o erro foi resolvido.


>Antes dos exercícios, precisamos criar o Model Ativo, porque ele será utilizado no comando Artisan e no Tinker.

```php
php artisan make:model Ativo -m
```
