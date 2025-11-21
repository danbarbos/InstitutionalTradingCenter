-- Show all open positions (not closed yet)
SELECT 
    position_id,
    portfolio_id,
    quantity,
    open_date,
    closed_date
FROM positions
WHERE closed_date IS NULL;
