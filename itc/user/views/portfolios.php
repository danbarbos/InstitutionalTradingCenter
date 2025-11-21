<?php
session_start();
require_once '../../db_config.php';

// Authentication check
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}

if ($conn === false) {
    die("<div class='error'>Database connection failed. Please contact administrator.</div>");
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <title>Portfolios Overview</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body class="body">

    <h2 class="section-title">Portfolios Overview</h2>

    <?php
    $sql = "
    SELECT 
        p.portfolio_id, 
        p.portfolio_name, 
        i.name AS institution_name,
        p.base_currency, 
        FORMAT(p.created_at, 'yyyy-MM-dd') AS created_date,
        (SELECT COUNT(*) FROM trades WHERE portfolio_id = p.portfolio_id) AS trade_count
    FROM 
        portfolios AS p
    JOIN 
        institutions AS i ON p.institution_id = i.institution_id
    ";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        echo "<div class='error'>Error executing query: " . print_r(sqlsrv_errors(), true) . "</div>";
    } else {
    ?>
        <div class="trades-table-container">
            <table class="trades-table">
                <thead>
                    <tr>
                        <th>Portfolio ID</th>
                        <th>Portfolio Name</th>
                        <th>Institution</th>
                        <th>Base Currency</th>
                        <th>Created Date</th>
                        <th>Trade Count</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['portfolio_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['portfolio_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['institution_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['base_currency']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['trade_count']) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php
        sqlsrv_free_stmt($stmt);
    }
    ?>

    <br />

    <a href="../../dashboard.php" class="submit-btn" style="max-width: 200px; display: inline-block;">Back to Dashboard</a>

</body>
</html>
