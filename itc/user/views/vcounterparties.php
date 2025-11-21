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
    <title>Information about Counterparties</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body class="body">

    <h2 class="section-title">Information about Counterparties</h2>

    <?php
    $sql = "SELECT counterparty_id, name, type, country, rating FROM dbo.counterparties";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        echo "<div class='error'>Error executing query: " . print_r(sqlsrv_errors(), true) . "</div>";
    } else {
    ?>
        <div class="trades-table-container">
            <table class="trades-table">
                <thead>
                    <tr>
                        <th>Counterparty ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Country</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['counterparty_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
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
