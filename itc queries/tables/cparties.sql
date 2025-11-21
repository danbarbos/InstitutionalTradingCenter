CREATE TABLE counterparties (
    counterparty_id INT PRIMARY KEY IDENTITY(1,1),
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL, -- e.g., Exchange, Broker, Bank
    country VARCHAR(50),
    rating VARCHAR(10) -- e.g., AA, BBB+
);