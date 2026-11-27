-- ============================================================================
-- SENAI Supply — Script de Banco de Dados (PostgreSQL)
-- Execute com: psql -U postgres -d senai_supply -f database/schema.sql
-- ============================================================================

-- Tabela de usuários (autenticação e perfis RBAC)
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(50) NOT NULL DEFAULT 'almoxarife',
    ativo BOOLEAN NOT NULL DEFAULT true,
    criado_em TIMESTAMP NOT NULL DEFAULT NOW()
);

-- Tabela de produtos / insumos do estoque
CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    quantidade INTEGER NOT NULL DEFAULT 0,
    estoque_minimo INTEGER NOT NULL DEFAULT 0,
    criado_em TIMESTAMP NOT NULL DEFAULT NOW()
);

-- Tabela de movimentações de estoque (entradas e saídas)
CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
    id SERIAL PRIMARY KEY,
    produto_id INTEGER NOT NULL REFERENCES produtos(id),
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id),
    tipo VARCHAR(20) NOT NULL CHECK (tipo IN ('entrada', 'saida')),
    quantidade INTEGER NOT NULL DEFAULT 0,
    observacao TEXT,
    criado_em TIMESTAMP NOT NULL DEFAULT NOW()
);

-- Índices para consultas rápidas
CREATE INDEX IF NOT EXISTS idx_movimentacoes_produto ON movimentacoes_estoque(produto_id);
CREATE INDEX IF NOT EXISTS idx_movimentacoes_usuario ON movimentacoes_estoque(usuario_id);
CREATE INDEX IF NOT EXISTS idx_movimentacoes_criado_em ON movimentacoes_estoque(criado_em);

-- Produtos de exemplo (insumos de manufatura 4.0)
INSERT INTO produtos (nome, descricao, quantidade, estoque_minimo) VALUES
('Parafuso M6x20', 'Parafuso de aço zincado para montagem', 150, 20),
('Porca M6', 'Porca sextavada de aço zincado', 200, 30),
('Arruela M6', 'Arruela plana de aço zincado', 300, 40)
ON CONFLICT DO NOTHING;

-- Usuários de teste (senhas criptografadas com BCrypt)
-- admin / admin123   -> acesso total
-- gestor / gestor123 -> leitura, entradas/saídas, painel
-- almoxarife / almox123 -> entrada/saída de produtos, catálogo
INSERT INTO usuarios (nome, email, senha, perfil, ativo) VALUES
('Administrador', 'admin@senai.local', '$2y$12$JSLHqL11vkBk06QeRgQcY.n65fggDCj0uyQnL9QwRe4WRnSA8DjWK', 'admin', true),
('Gestor de Estoque', 'gestor@senai.local', '$2y$12$nHpoZ2nkpEHFAUVQMSgwmuk06oYrRkR5HqyxyY/wFJMXTv4NIJ7C2', 'gestor', true),
('Almoxarife', 'almoxarife@senai.local', '$2y$12$XO2VoKIleP1xl2lnA.umXeLQ/8kC6g4JXhgTqcvoM/ObOQqkt/MUG', 'almoxarife', true)
ON CONFLICT (email) DO NOTHING;

-- Mensagem de confirmação
SELECT 'Banco de dados SENAI Supply criado com sucesso!' AS status;
