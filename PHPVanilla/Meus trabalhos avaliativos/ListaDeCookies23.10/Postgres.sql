CREATE TABLE auditoria_logins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    ip VARCHAR(45),
    user_agent TEXT,
    sucesso BOOLEAN NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);