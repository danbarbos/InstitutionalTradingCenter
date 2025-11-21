CREATE TABLE portfolios (
    portfolio_id INT PRIMARY KEY IDENTITY(1,1),
    institution_id INT NOT NULL,
    portfolio_name VARCHAR(100) NOT NULL,
    base_currency VARCHAR(10) NOT NULL,
    created_at DATETIME DEFAULT GETDATE(),

    FOREIGN KEY (institution_id) REFERENCES institutions(institution_id)
);