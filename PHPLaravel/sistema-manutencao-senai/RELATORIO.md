### Relatório — Implementação do SENAI Maintenance Flow

O projeto já possuía uma estrutura inicial em Laravel, com o PHP e o banco de dados SQLite configurados, além de algumas rotas, Models, Migrations e Controllers. Porém, ainda havia algumas partes incompletas, principalmente na parte visual, pois praticamente todas as telas precisavam ser desenvolvidas. 
Por isso, comecei modificando algumas coisas que já existia no repositório e realizando os ajustes necessários para que tudo funcionasse corretamente.

Durante essa etapa, `fiz alterações nos Models de Equipamento e OrdemServico, organizei as migrations, ajustei os nomes das tabelas e implementei métodos que ainda estavam faltando nos Controllers.` Também precisei realizar algumas configurações no arquivo .env e no php.ini para garantir o funcionamento do banco de dados SQLite.

Uma das principais partes do desenvolvimento foi a criação das telas utilizando o Blade. Foram desenvolvidos 15 arquivos de visualização, incluindo um layout principal, componentes reutilizáveis, dashboard, páginas de equipamentos, ordens de serviço e uma barra de filtros. Com isso, consegui aplicar na prática conceitos como @extends, @section e @yield, que permitem compartilhar uma mesma estrutura entre diferentes páginas, evitando a repetição de códigos.

Também utilizei `componentes Blade, como os cartões de indicadores, etiquetas de prioridade e status e mensagens de alerta. Outro recurso importante foi o uso das diretivas @if, @forelse, @empty e da variável $loop, que ajudaram a organizar a exibição das informações e tornar as listas mais dinâmicas. Além disso, utilizei o @include para reaproveitar partes das páginas e o @push junto com @stack para inserir scripts em locais específicos do layout.`

Durante a implementação, também tive atenção à `segurança da aplicação. Utilizei o escape automático do Blade com {{ }},` que ajuda a impedir a execução de códigos maliciosos enviados pelos usuários. Nos formulários, foram aplicadas as diretivas @csrf e @method, garantindo maior proteção nas operações de cadastro, edição e exclusão.

Depois de finalizar a implementação, realizei os testes para verificar se todas as funcionalidades estavam funcionando como esperado. Testei o redirecionamento para o dashboard, a exibição dos indicadores, a navegação entre as páginas, os filtros de ordens de serviço, a apresentação de listas vazias e a proteção contra ataques XSS. Também verifiquei a compilação das views e o funcionamento dos scripts de impressão. Todos os oito testes previstos no guia foram concluídos com sucesso.

Além disso, inseri dados de teste diretamente no banco de dados para conferir o funcionamento do sistema com informações reais de equipamentos e ordens de serviço. Com isso, consegui verificar a exibição de cinco equipamentos, seis ordens de serviço e a atualização dos indicadores do dashboard.

## Ao longo dessa atividade
 consegui compreender melhor como o Laravel organiza uma aplicação e como o Blade facilita a criação de páginas mais organizadas, dinâmicas e reutilizáveis. Também percebi a importância de manter os arquivos bem estruturados, utilizar componentes e pensar na segurança desde o desenvolvimento.
