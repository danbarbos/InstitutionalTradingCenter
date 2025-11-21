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
    <title>Trade History</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body class="body">

    <h2 class="section-title">Trade History</h2>

    <?php
    $sql = "
    SELECT t.trade_id, t.trade_date, t.side, t.quantity, t.price, t.currency, 
           c.name AS counterparty_name, p.portfolio_name, i.name AS institution_name, t.instrument
    FROM dbo.trades AS t
    INNER JOIN dbo.counterparties AS c ON t.counterparty_id = c.counterparty_id
    INNER JOIN dbo.portfolios AS p ON t.portfolio_id = p.portfolio_id
    INNER JOIN dbo.institutions AS i ON p.institution_id = i.institution_id
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
                        <th>Trade ID</th>
                        <th>Trade Date</th>
                        <th>Side</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Counterparty Name</th>
                        <th>Portfolio Name</th>
                        <th>Institution Name</th>
                        <th>Instrument</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['trade_id']) . "</td>";

                    if ($row['trade_date'] instanceof DateTime) {
                        echo "<td>" . htmlspecialchars($row['trade_date']->format('Y-m-d H:i:s')) . "</td>";
                    } elseif (!empty($row['trade_date'])) {
                        $date = date_create($row['trade_date']);
                        if ($date) {
                            echo "<td>" . htmlspecialchars($date->format('Y-m-d H:i:s')) . "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($row['trade_date']) . "</td>";
                        }
                    } else {
                        echo "<td>-</td>";
                    }

                    echo "<td>" . htmlspecialchars($row['side']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['currency']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['counterparty_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['portfolio_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['institution_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['instrument']) . "</td>";
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
