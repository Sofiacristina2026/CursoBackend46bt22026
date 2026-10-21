### Parte A: Questôes Téoricas de Fixaçõa ###

1. A diferença entre Procedural vs. OO: Os três principais riscos de utilizar apenas arrays associativos e scripts procedurais em regras financeiras são a falta de segurança dos dados, a dificuldade de manutenção do código e o maior risco de erros financeiros. Isso acontece porque diferentes partes do sistema podem alterar saldos sem ver ou checar as regras necessárias. A Programação Orientada a Objetos (POO) ajuda assim a organizar o código, proteger os dados e centralizar as regras financeiras.

2. Ciclo de Vida do Objeto: Quando o comando new ContaCorrente(...) é executado, o PHP cria um objeto na memória Heap do servidor, onde ficam armazenados seus atributos. O método __construct() é executado automaticamente durante a criação do objeto e serve para inicializar seus atributos com os valores recebidos.

3. A Pseudo-Variável $this: O comando $this->saldo é utilizado para acessar o atributo saldo do objeto atual dentro da classe. Já a variável local $saldo existe apenas dentro de uma função ou método e não representa necessariamente o saldo armazenado no objeto. Por isso, $this->saldo permite acessar o atributo correto da conta.

4. Encapsulamento e Invariantes: Não é recomendado criar um método público setSaldo(float $novoSaldo) porque ele permitiria alterar o saldo diretamente, sem verificar se a operação é válida. Isso poderia gerar saldos incorretos e quebrar as regras da conta bancária. O ideal é utilizar métodos controlados, como depositar() e sacar(), que verificam as condições necessárias antes de modificar o saldo.

5. Modificadores de Acesso: O modificador private permite acessar atributos e métodos somente dentro da própria classe em que foram declarados. Já o protected permite o acesso dentro da própria classe e também nas classes filhas que utilizam extends. Assim, private oferece maior restrição, enquanto protected permite que as subclasses utilizem determinados recursos herdados.

6. Constructor Property Promotion: O Constructor Property Promotion, introduzido no PHP 8, permite declarar e inicializar atributos diretamente nos parâmetros do construtor, utilizando modificadores como public, private ou protected. Isso reduz a quantidade de código repetido, chamada de boilerplate, tornando o código menor, mais organizado e fácil de entender.

7. Propriedades readonly: A palavra-chave readonly permite que um atributo seja inicializado e não tenha seu valor alterado livremente depois disso. Em classes de valor, como Titular ou CPF, esse recurso ajuda a proteger informações que devem permanecer constantes após a criação do objeto, evitando alterações acidentais.

8. Classes Abstratas: A classe ContaBancaria deve ser abstrata porque representa um modelo geral de conta bancária, reunindo atributos e comportamentos comuns. Ela não pode ser instanciada diretamente com new. Em vez disso, classes concretas, como ContaCorrente e ContaPoupanca, herdam suas características e implementam os comportamentos específicos de cada tipo de conta.

9. Polimorfismo: O método transferir(float $valor, ContaBancaria $destino) consegue realizar transferências entre diferentes tipos de contas porque recebe qualquer objeto que seja uma instância de ContaBancaria ou de uma de suas subclasses. Dessa forma, ele pode trabalhar com ContaCorrente ou ContaPoupanca sem precisar verificar a classe exata da conta de destino, respeitando os comportamentos definidos para cada tipo.

10. Exceções de Domínio: Retornar false ou null quando um saque é rejeitado por falta de saldo pode dificultar a identificação do motivo da falha. Se o código que chamou o método não verificar o retorno corretamente, o problema pode passar despercebido. O ideal é lançar uma exceção de domínio, como SaldoInsuficienteException, para informar claramente o motivo pelo qual o saque não pôde ser realizado e permitir que o erro seja tratado adequadamente.