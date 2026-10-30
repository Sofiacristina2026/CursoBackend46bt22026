<?php
declare(strict_types=1);
require_once __DIR__ . '/conexao.php';

// Organiza as operações de cadastro e consulta de usuários.
class UsuarioDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Cadastra o usuário utilizando parâmetros preparados.
    public function cadastrar(
        string $nome,
        string $email,
        string $hash
    ): bool {
        $sql = 'INSERT INTO usuarios (nome, email, senha_hash)
                VALUES (:nome, :email, :hash)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'hash' => $hash,
        ]);
    }

    // Busca um usuário pelo e-mail informado.
    public function buscarPorEmail(string $email): array|false
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
