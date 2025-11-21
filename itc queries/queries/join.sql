-- Show all trades along with the portfolio name and institution name
SELECT 
    t.trade_id,
    t.trade_date,
    p.portfolio_name,
    i.name AS institution_name,
    t.quantity,
    t.price,
    t.notional_value
FROM trades t
INNER JOIN portfolios p ON t.portfolio_id = p.portfolio_id
INNER JOIN institutions i ON p.institution_id = i.institution_id;