## O que é Backednd
Backend é a interface entre o servidor e o usúario. Uma resposta para uma requisição.

#### Como funciona na prática o Backend ?

- ***Ação do usúario**: Envia uma solicitação pela UI(Inteface do Usuário). Exemplo de UI: Tela do celular, Navegador da Internet,Alexa. Gemini,IOT ...
- **Enviar uma requisição**: A UI Transforma a ação do usuário em uma requisição HTTP.
-**Processamento pelo Backend**: O código backend recebe o pedido valida os dados e decide o que fazer.Exemplo:Consultar uma informação no BD(A base de dados).
- **Resposta**: O servidor devolve o resultado para a UI. Exemplo: Um login autorizado, a confirmação de uma compra...
-----

### Tipos de Requisições HTTP:

Os tipos de requisições HTTP indicam a açãoque o usuário deseja executar no servidor. As principais ações são:
 
 - **GET**: Pede dados de um luhgar específico do servidor. "Não faz alterações no servidor"
 - ** DELETE**: Apaga um dado do servidor.
 - **post**: eLA ENVIA DADOS NOVOS PARA *criar* algo ou processar insformações no servidor.
 - **PUT/PATCH**: Modificar um dado já existente.

 >Obs: Diferença entre os comando : (Put) faz uma alteração completa já o PATCH faz uma alteração parcial.
----

### Iniciando o PHP

**PHP** (hyperTxt PreProcessor) é uma linguagem de programação interpretada e open source,focada no desenvolvimento de sistemas para web,pode ser usada junto com o HTML para criaçõa de páginas web dinâmicas.

O PHP de fato é uma das linguagens de programação mais populares da  atualidade. Ela permite que você crie aplicações web robustas, de uma muito simplificada e direta. A linguagem tem diversos recursos que facilitam e aceleram o processo de desenvolvimento de sites e sistemas para web. E além do mais, ela ainda tem um otímo ecosistema, uma excelente comunidade e um grande mercado de trabalho.

-----

##### Instalando o PHP

- Fazer o Dowload do php em (php.net)
- Zip - NTS(Non Thread Safe) 8.5
- Descompactar o arquivo do PHP na pasta C:src\php (Para descompactar usar o 7zip + melhor ) => Nunca salvar arquivos ou programas na raiz do sistema(C:)
- Adicionar a Pasta do PHP(c:\src\php) As varaiáveis de ambiente do Sistema (PATH)
- Verificar a instalação com o comando *php--version*

#### Criando minha primeira Aplicação em PHP 
