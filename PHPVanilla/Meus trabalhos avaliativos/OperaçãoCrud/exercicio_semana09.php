-- Cria a tabela usada no cadastro de ferramentas.

CREATE TABLE IF NOT EXISTS ferramentas (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Cria a tabela de peças industriais.
CREATE TABLE IF NOT EXISTS pecas_industriais (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    estoque INTEGER NOT NULL DEFAULT 0 CHECK (estoque >= 0),
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Registra as entradas e saídas de estoque para auditoria.
CREATE TABLE IF NOT EXISTS movimentacoes (
    id SERIAL PRIMARY KEY,
    peca_id INTEGER NOT NULL REFERENCES pecas_industriais(id),
    quantidade INTEGER NOT NULL CHECK (quantidade > 0),
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('entrada', 'saida')),
    data_movimentacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Insere ferramentas para testar as consultas.
INSERT INTO ferramentas (nome, descricao)
VALUES
    ('Chave de fenda', 'Ferramenta manual'),
    ('Alicate', 'Ferramenta de aperto');

-- Insere peças para testar a paginação e o estoque.
INSERT INTO pecas_industriais (nome, sku, estoque)
VALUES
    ('Parafuso', 'P001', 100),
    ('Porca', 'P002', 80),
    ('Arruela', 'P003', 150),
    ('Rolamento', 'P004', 20),
    ('Correia', 'P005', 15),
    ('Engrenagem', 'P006', 10);