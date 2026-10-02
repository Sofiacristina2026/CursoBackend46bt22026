## 8. LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA

### Parte A: Exercícios Teóricos de Fixação

1. **Definição de CRUD:** O que significa o acrônimo CRUD e qual é a correspondência direta de cada uma de suas letras com as instruções SQL no PostgreSQL?
   **Resposta:** CRUD significa **Create, Read, Update e Delete**. No SQL, eles correspondem respectivamente a **INSERT** (criar), **SELECT** (ler/buscar), **UPDATE** (alterar) e **DELETE** (excluir).

2. **Anatomia do SQL Injection:** Explique com suas próprias palavras como um atacante consegue alterar a lógica de uma consulta quando o código utiliza concatenação de strings com `$_GET` ou `$_POST`.
   **Resposta:** Isso acontece quando o valor enviado pelo usuário é colocado diretamente dentro da consulta SQL. O atacante pode inserir comandos ou trechos de SQL no campo enviado, fazendo com que o banco interprete esse conteúdo como parte da consulta e altere sua lógica.

3. **Mecanismo das Prepared Statements:** Por que o envio de uma consulta em duas etapas (prepare e depois execute) impede que um texto digitado pelo usuário seja executado como instrução SQL pelo banco?
   **Resposta:** Porque a consulta SQL é preparada separadamente dos dados enviados pelo usuário. Assim, o conteúdo digitado é tratado como **valor**, e não como parte do comando SQL, evitando que ele seja interpretado como uma instrução.

4. **Marcadores Nomeados:** Qual é a vantagem de utilizar marcadores nomeados como `:sku` e `:preco` em vez de pontos de interrogação posicionais (`?`) em instruções SQL complexas?
   **Resposta:** Os marcadores nomeados deixam o código mais fácil de entender, pois mostram qual dado será colocado em cada lugar. Em consultas maiores, isso também ajuda a evitar confusão na ordem dos parâmetros.

5. **Diferença entre Bindings:** Explique a diferença de comportamento entre os métodos `$stmt->bindValue()` e `$stmt->bindParam()`.
   **Resposta:** O `bindValue()` vincula o **valor atual** da variável ao parâmetro. Já o `bindParam()` vincula a **variável em si**, fazendo com que o valor usado possa mudar antes da execução da consulta.

6. **Tipagem no PDO:** Qual é o risco de omitir o tipo de dado (ex: `PDO::PARAM_INT`) ao vincular uma variável que deveria ser estritamente numérica em uma cláusula LIMIT?
   **Resposta:** O valor pode ser tratado como uma string em vez de um número inteiro. Isso pode causar erros ou comportamentos inesperados na consulta. Informar `PDO::PARAM_INT` deixa claro para o PDO que o valor deve ser tratado como inteiro.

7. **Padrão DAO:** Qual é o benefício do padrão *Data Access Object* (DAO) em termos de manutenibilidade de software e do princípio de responsabilidade única (SOLID)?
   **Resposta:** O DAO separa a parte responsável pelo acesso ao banco de dados do restante da aplicação. Assim, cada classe fica com uma responsabilidade específica, deixando o código mais organizado, fácil de manter e de alterar.

8. **Operações de Update:** Por que a ausência de uma cláusula WHERE em um comando UPDATE é considerada um incidente gravíssimo em ambientes de produção?
   **Resposta:** Porque um `UPDATE` sem `WHERE` pode alterar **todos os registros da tabela**. Isso pode causar uma grande perda ou alteração indevida de dados, sendo difícil ou até impossível recuperar as informações originais.

9. **Impacto da LGPD:** De acordo com a Lei Geral de Proteção de Dados (LGPD), quais são as penalidades e impactos que uma organização pode sofrer caso ocorra vazamento de dados de clientes por falha de SQL Injection?
   **Resposta:** A organização pode sofrer medidas e sanções administrativas previstas na LGPD, como **advertência, multa simples de até 2% do faturamento da empresa no Brasil, limitada a R$ 50 milhões por infração, multa diária, bloqueio ou eliminação dos dados pessoais envolvidos**, entre outras medidas. Além disso, o vazamento pode causar prejuízos financeiros, danos à reputação e necessidade de comunicar o incidente às autoridades e aos titulares quando aplicável.
