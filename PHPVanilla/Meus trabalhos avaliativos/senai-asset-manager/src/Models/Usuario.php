<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use App\Core\Logger;

/**
 * Usuario — Modelo de domínio para usuários do sistema.
 *
 * Responsável pela autenticação (password_hash / password_verify)
 * e consultas à tabela usuarios.
 *
 * Senhas são armazenadas exclusivamente com hash BCrypt. Nunca em texto puro.
 */
class Usuario
{
    /**
     * Busca um usuário pelo e-mail.
     *
     * @return array|null Dados do usuário ou null se não encontrado
     */
    public static function buscarPorEmail(string $email): ?array
    {
        $pdo = ConexaoBanco::getInstance();
        $stmt = $pdo->prepare(
            'SELECT id, nome, email, senha, perfil, ativo
             FROM usuarios
             WHERE email = :email
             LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    /**
     * Autentica um usuário verificando a senha com password_verify().
     *
     * @return array|null Dados do usuário (sem a senha) ou null se falhar
     */
    public static function autenticar(string $email, string $senha): ?array
    {
        $usuario = self::buscarPorEmail($email);

        if ($usuario === null) {
            Logger::aviso('Tentativa de login com e-mail não cadastrado', [
                'email' => $email,
                'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            return null;
        }

        if (!$usuario['ativo']) {
            Logger::aviso('Tentativa de login com usuário inativo', [
                'email' => $email,
                'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            return null;
        }

        if (!password_verify($senha, $usuario['senha'])) {
            Logger::aviso('Tentativa de login com senha inválida', [
                'email' => $email,
                'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            ]);
            return null;
        }

        // Remove a senha do array antes de retornar
        unset($usuario['senha']);

        Logger::info('Login realizado com sucesso', [
            'usuario_id' => $usuario['id'],
            'email'      => $email,
            'perfil'     => $usuario['perfil'],
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        return $usuario;
    }

    /**
     * Lista todos os usuários (sem senhas).
     *
     * @return array Lista de usuários
     */
    public static function listarTodos(): array
    {
        $pdo = ConexaoBanco::getInstance();
        $stmt = $pdo->query(
            'SELECT id, nome, email, perfil, ativo, criado_em
             FROM usuarios
             ORDER BY nome ASC'
        );
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Cadastra um novo usuário com senha criptografada (password_hash BCrypt).
     *
     * @return int ID do usuário inserido
     */
    public static function criar(array $dados): int
    {
        $pdo = ConexaoBanco::getInstance();

        $hash = password_hash($dados['senha'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare(
            'INSERT INTO usuarios (nome, email, senha, perfil, ativo)
             VALUES (:nome, :email, :senha, :perfil, :ativo)'
        );
        $stmt->execute([
            ':nome'   => $dados['nome'],
            ':email'  => $dados['email'],
            ':senha'  => $hash,
            ':perfil' => $dados['perfil'] ?? 'almoxarife',
            ':ativo'  => $dados['ativo'] ?? true,
        ]);

        Logger::info('Novo usuário cadastrado', [
            'usuario_id' => (int) $pdo->lastInsertId(),
            'email'      => $dados['email'],
            'perfil'     => $dados['perfil'] ?? 'almoxarife',
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ]);

        return (int) $pdo->lastInsertId();
    }
}
