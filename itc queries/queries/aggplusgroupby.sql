-- Total notional traded per institution
SELECT 
    i.name AS institution_name,
    SUM(t.notional_value) AS total_notional
FROM trades t
INNER JOIN portfolios p ON t.portfolio_id = p.portfolio_id
INNER JOIN institutions i ON p.institution_id = i.institution_id
GROUP BY i.name;
