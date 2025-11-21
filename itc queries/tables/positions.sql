CREATE TABLE positions (
    position_id INT PRIMARY KEY IDENTITY(1,1),
    portfolio_id INT NOT NULL,
    instrument VARCHAR(10),
    quantity DECIMAL(18,4) NOT NULL CHECK (quantity > 0),
    avg_entry_price DECIMAL(18,4) NOT NULL,
    position_type VARCHAR(10) CHECK (position_type IN ('Long', 'Short')),
    open_date DATE NOT NULL,
    closed_date DATE,

    FOREIGN KEY (portfolio_id) REFERENCES portfolios(portfolio_id)
    
);
