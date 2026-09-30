# Situação de Aprendizagem Formativa - Criação de um CRUD com PDO e Proteção contra SQL Injection

## Passo 1 - Montegem das Estruturas de Diretórios e Arquivos de Aplicação

```text
SACRUD/
|__ config/
    |__ database.ini        <-Credencias protegidas de acesso ao Banco de Dados >
|Dados>
|__ logs/
|   |__database.log          <- Time de Desenvolvimento recebe os logs de Falhas do Sistema
|__ src/
|    |__ConexaoBanco.php     <- Classe Singleton de conexão com PDO
|    |__AlmoxarifadoDAO.php  <- Camada de acesso a dados (CRUD com Prepared Statement)
|__ index.php                <- Controlador e interface visual
|__ schema.sql               <- Script do banco de Dados
|__ .gitignore               <- arquivos fora do versionamento
|__ README.md                <- Documentação do PRojeto

```
