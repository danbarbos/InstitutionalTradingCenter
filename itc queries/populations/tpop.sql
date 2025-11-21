INSERT INTO trades (portfolio_id, instrument_id, counterparty_id, trade_date, settlement_date, side, quantity, price, currency)
VALUES 
(1, APPL, 1, '2025-01-02 09:15', '2025-01-04', 'Buy', 100000.00, 1.0900, 'USD'),
(1, MSFT, 1, '2025-01-10 10:45', '2025-01-12', 'Buy', 50000.00, 1.1000, 'USD'),
(2, NVDA, 2, '2025-02-01 14:00', '2025-02-03', 'Sell', 50.00, 1980.25, 'USD'),
(3, TSLA, 3, '2025-03-10 11:30', '2025-03-12', 'Buy', 200000.00, 0.8750, 'CHF');
