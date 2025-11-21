--institutions from the same country as others (not itself)
SELECT 
    A.name AS institution_name,
    B.name AS peer_institution,
    A.country
FROM institutions A
JOIN institutions B 
    ON A.country = B.country AND A.institution_id <> B.institution_id;
