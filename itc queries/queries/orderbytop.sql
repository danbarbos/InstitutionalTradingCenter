-- Top 2 largest trades by notional
SELECT TOP 2 
    trade_id, notional_value
FROM trades
ORDER BY notional_value DESC;
