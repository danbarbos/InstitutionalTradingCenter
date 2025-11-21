CREATE TABLE institutions (
    institution_id INT PRIMARY KEY IDENTITY(1,1),
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL, -- e.g., Bank, Hedge Fund, Broker
    country VARCHAR(50),
    regulatory_id VARCHAR(50) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT GETDATE()
);