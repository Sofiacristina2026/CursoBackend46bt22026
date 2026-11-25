-- Remover tabelas se já existirem (cuidado em produção)
DROP TABLE IF EXISTS movimentacoes_estoque;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS usuarios;

-- Tabela de Usuários com RBAC (perfis: admin, gestor, almoxarife)
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(30) NOT NULL CHECK (perfil IN ('admin', 'gestor', 'almoxarife')),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Produtos / Insumos
CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    quantidade INT NOT NULL DEFAULT 0 CHECK (quantidade >= 0),
    preco NUMERIC(10, 2) NOT NULL,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Movimentações de Estoque (Entradas e Saídas)
CREATE TABLE movimentacoes_estoque (
    id SERIAL PRIMARY KEY,
    produto_id INT REFERENCES produtos(id) ON DELETE RESTRICT,
    usuario_id INT REFERENCES usuarios(id) ON DELETE RESTRICT,
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('ENTRADA', 'SAIDA')),
    quantidade INT NOT NULL CHECK (quantidade > 0),
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de Usuários Padrão (Senhas geradas com password_hash('senha123', PASSWORD_BCRYPT))
-- Senha para todos: senha123
INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Administrador Geral', 'admin@senai.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Gestor de Produção', 'gestor@senai.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gestor'),
('Almoxarife João', 'almoxarife@senai.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'almoxarife');

-- Inserção de produtos iniciais
INSERT INTO produtos (nome, descricao, quantidade, preco) VALUES
('Chapa de Aço Inox', 'Chapa 2mm para estruturação', 150, 450.00),
('Parafuso M6 x 20mm', 'Caixa com 100 unidades', 500, 35.50),
('Sensor de Proximidade Indutivo', 'Sensor 24V DC', 40, 120.00);