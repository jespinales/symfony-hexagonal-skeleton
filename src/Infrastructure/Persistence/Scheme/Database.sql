CREATE TABLE IF NOT EXISTS users (
    id CHAR(36) NOT NULL,
    name VARCHAR(50),
    email VARCHAR(100),
    PRIMARY KEY (id)
);