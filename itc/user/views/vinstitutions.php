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
    <title>Information about Institutions</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body class="body">

    <h2 class="section-title">Information about Institutions</h2>

    <?php
    $sql = "SELECT institution_id, name, type, country, regulatory_id, created_at FROM dbo.institutions";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        echo "<div class='error'>Error executing query: " . print_r(sqlsrv_errors(), true) . "</div>";
    } else {
    ?>
        <div class="trades-table-container">
            <table class="trades-table">
                <thead>
                    <tr>
                        <th>Institution ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Country</th>
                        <th>Regulatory ID</th>
                        <th>Creation Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['institution_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['regulatory_id']) . "</td>";

                    if ($row['created_at'] instanceof DateTime) {
                        echo "<td>" . htmlspecialchars($row['created_at']->format('Y-m-d H:i:s')) . "</td>";
                    } elseif (!empty($row['created_at'])) {
                        $date = date_create($row['created_at']);
                        if ($date) {
                            echo "<td>" . htmlspecialchars($date->format('Y-m-d H:i:s')) . "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        }
                    } else {
                        echo "<td>-</td>";
                    }
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
