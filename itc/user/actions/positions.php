<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$sql = "
SELECT pos.position_id, pos.instrument, pos.quantity, pos.avg_entry_price, pos.open_date, p.portfolio_name, ins.name AS institution_name
FROM dbo.positions pos
INNER JOIN dbo.portfolios p ON pos.portfolio_id = p.portfolio_id
INNER JOIN dbo.institutions ins ON p.institution_id = ins.institution_id
WHERE pos.closed_date IS NULL
";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    $error = print_r(sqlsrv_errors(), true);
}

function getCurrentPrice($instrument) {
    $prices = [
        'AAPL' => 195.27,
        'MSFT' => 310.50,
        'GOOGL' => 2800.10,
        'AMZN' => 3500.00,
        'META' => 210.00
    ];
    return $prices[$instrument] ?? null;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <title>Position Manager</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body class="body">
    <h2 class="section-title">Position Manager</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($stmt !== false): ?>
        <div class="trades-table-container">
            <table class="trades-table">
                <thead>
                    <tr>
                        <th>Position ID</th>
                        <th>Instrument</th>
                        <th>Quantity</th>
                        <th>Average Entry Price</th>
                        <th>Open Date</th>
                        <th>Portfolio Name</th>
                        <th>Institution Name</th>
                        <th>Profit (USD)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $open_date = $row['open_date'] instanceof DateTime ? $row['open_date']->format('Y-m-d') : htmlspecialchars($row['open_date']);
                        $current_price = getCurrentPrice($row['instrument']);
                        $profit = null;
                        if ($current_price !== null) {
                            $profit = ($current_price - $row['avg_entry_price']) * $row['quantity'];
                        }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['position_id']) ?></td>
                            <td><?= htmlspecialchars($row['instrument']) ?></td>
                            <td class="number-cell"><?= number_format($row['quantity'], 2) ?></td>
                            <td class="price-cell"><?= number_format($row['avg_entry_price'], 2) ?></td>
                            <td class="date-cell"><?= $open_date ?></td>
                            <td><?= htmlspecialchars($row['portfolio_name']) ?></td>
                            <td><?= htmlspecialchars($row['institution_name']) ?></td>
                            <td class="price-cell"><?= $profit !== null ? number_format($profit, 2) : 'N/A' ?></td>
                            <td>
                                <form method="POST" action="close_position.php" onsubmit="return confirm('Are you sure you want to close this position?');">
                                    <input type="hidden" name="position_id" value="<?= htmlspecialchars($row['position_id']) ?>">
                                    <button type="submit" class="submit-btn" style="padding:6px 12px; font-size:14px;">Close position</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    sqlsrv_free_stmt($stmt);
                    ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No positions.</p>
    <?php endif; ?>

    <br>
    <a href="../../dashboard.php" class="submit-btn" style="max-width: 200px; display: inline-block;">Back to Dashboard</a>

</body>
</html>
