CREATE TABLE cuentas (
    id SERIAL PRIMARY KEY,
    titular VARCHAR(100) NOT NULL,
    saldo DECIMAL(10,2) NOT NULL DEFAULT 0.00
);

-- Insertar datos de ejemplo en la tabla cuentas
INSERT INTO cuentas (titular, saldo) VALUES
('Juan Pérez', 500.00),
('Ana Gómez', 1200.50),
('Carlos Ruiz', 300.75);
