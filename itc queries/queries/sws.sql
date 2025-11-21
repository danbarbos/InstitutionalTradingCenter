-- List portfolios that traded more than the average notional
SELECT 
    portfolio_id,
    SUM(notional_value) AS total_notional
FROM trades
GROUP BY portfolio_id
HAVING SUM(notional_value) > (
    SELECT AVG(notional_value) FROM trades
);
