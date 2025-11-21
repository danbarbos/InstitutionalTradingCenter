CREATE TABLE trades (
    trade_id INT PRIMARY KEY IDENTITY(1,1),
    portfolio_id INT NOT NULL,
    instrument VARCHAR(10),
    counterparty_id INT NOT NULL,
    trade_date DATETIME NOT NULL,
    settlement_date DATE NOT NULL,
    side VARCHAR(10) NOT NULL CHECK (side IN ('Buy', 'Sell')),
    quantity DECIMAL(18,4) NOT NULL CHECK (quantity > 0),
    price DECIMAL(18,4) NOT NULL,
    notional_value AS (quantity * price) PERSISTED,
    currency VARCHAR(10) NOT NULL,

    FOREIGN KEY (portfolio_id) REFERENCES portfolios(portfolio_id),
    FOREIGN KEY (counterparty_id) REFERENCES counterparties(counterparty_id)
);