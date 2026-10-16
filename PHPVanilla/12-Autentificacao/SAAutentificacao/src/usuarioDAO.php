<?php
declare(strict_types=1);

//Criação da Classe de Acesso aos Dados da TAbela Usuários

final class UsuarioDAO{
    //atributos
    private PDO $pdo; // pegar as informações da conexão com o Banco de dados

    //Toda classe precisa de um construtor 
    //SNEPTS = são atalhos 
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    //métodos de manipulação de dados (CRUD)
    //Create -> Cadastrar
    public function cadastrar(string $nome, string $email, string $senha, string $perfil = "OPERADOR"):bool{
        $sql="INSERT INTO usuarios(nome, email, senha_hash, perfil)
              VALUES(:nome, :email, :hash, :perfil)";
        $stmt = $this->pdo->prepare($sql);

        //hash da senha
        $hash = password_hash($senha, PASSWORD_ARGON2ID);

        return $stmt->execute([
            ":nome"     => trim($nome),
            ":email"    => strtolower(trim($email)),
            ":hash"     => $hash,
            ":perfil"   => $perfil
        ]);
    }

    // buscar dados do usuário pelo email
    public function buscarPorEmail(string $email): ?array{
        $sql="SELECT * FROM usuarios WHERE email = :email AND ativo = TRUE";
        $stmt= $this->pdo->prepare($sql);
        $stmt->bindValue(":email", strtolower(trim($email)), PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    //Buscar um e-mail cadastrado -> Verificar se o email já está cadastrado 
    public function emailExiste(String $email): bool{
        //Busca apenas a coluna do email a aprtir do email digitado
        $sql = "SELECT 1 FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        //Ajusta o Email digitado para minusculo e recorta os espaços em branco
        $stmt->bindValue(":email", strtolower(trim($email)), PDO::PARAM_STR);
        //executa a busca 
        $stmt->execute();
        //Se o email for encontrado retorna true se não retorna false 
        // Se chama CAST para garantir que o retorno vai ser uma boleana
        return (bool)$stmt->fetchColumn(); 

        }
        // esta faltando um update 

        //E esta faltando um delete 
}

