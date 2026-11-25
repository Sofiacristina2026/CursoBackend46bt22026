
-- Banco de dados SENAI Supply
-- Tabelas de usuarios, produtos e movimentacoes

CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL
        CHECK (perfil IN ('gestor', 'almoxarife', 'admin')),
    ativo BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT,
    quantidade INTEGER NOT NULL DEFAULT 0
        CHECK (quantidade >= 0),
    estoque_minimo INTEGER NOT NULL DEFAULT 5,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
    id SERIAL PRIMARY KEY,
    produto_id INTEGER NOT NULL
        REFERENCES produtos(id),
    usuario_id INTEGER NOT NULL
        REFERENCES usuarios(id),
    tipo VARCHAR(10) NOT NULL
        CHECK (tipo IN ('entrada', 'saida')),
    quantidade INTEGER NOT NULL
        CHECK (quantidade > 0),
    observacao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Produtos iniciais para testar o sistema

INSERT INTO produtos (nome, descricao, quantidade, estoque_minimo)
VALUES
('Parafuso', 'Parafuso industrial', 100, 10),
('Porca', 'Porca de aço', 80, 10),
('Arruela', 'Arruela metálica', 50, 5)
ON CONFLICT DO NOTHING;

-- Índices para facilitar as consultas

CREATE INDEX IF NOT EXISTS idx_movimentacoes_produto
ON movimentacoes_estoque(produto_id);

CREATE INDEX IF NOT EXISTS idx_movimentacoes_usuario
ON movimentacoes_estoque(usuario_id);

