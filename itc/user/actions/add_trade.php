<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lista instrumentelor cu simboluri Alpha Vantage
$instruments = [
    'Apple' => 'AAPL',
    'Microsoft' => 'MSFT',
    'Google' => 'GOOGL',
    'Amazon' => 'AMZN',
    'Facebook (Meta)' => 'META'
];

// Preluare portofolii
$portfolio_result = sqlsrv_query($conn, "SELECT portfolio_id, portfolio_name FROM portfolios");

// Preluare counterparties
$counterparty_result = sqlsrv_query($conn, "SELECT counterparty_id, name FROM counterparties");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $portfolio_id = $_POST['portfolio_id'] ?? null;
    $instrument = $_POST['instrument'] ?? null;
    $counterparty_id = $_POST['counterparty_id'] ?? null;
    $trade_date = $_POST['trade_date'] ?? null;
    $settlement_date = $_POST['settlement_date'] ?? null;
    $side = $_POST['side'] ?? null;
    $quantity = isset($_POST['quantity']) ? floatval($_POST['quantity']) : 0;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $currency = $_POST['currency'] ?? null;

    if (!$portfolio_id || !$instrument || !$counterparty_id || !$trade_date || !$settlement_date || !$side || $quantity <= 0 || $price <= 0 || !$currency) {
        $message = "Te rog completează toate câmpurile corect și asigură-te că cantitatea și prețul sunt pozitive.";
    } else {
        $trade_date = str_replace('T', ' ', $trade_date) . ':00';
        $settlement_date = str_replace('T', ' ', $settlement_date) . ':00';

        // 1. Inserare trade
        $sqlTrade = "INSERT INTO trades (
            portfolio_id, instrument, counterparty_id,
            trade_date, settlement_date, side,
            quantity, price, currency
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $paramsTrade = [
            $portfolio_id, $instrument, $counterparty_id,
            $trade_date, $settlement_date, $side,
            $quantity, $price, $currency
        ];

        $stmtTrade = sqlsrv_query($conn, $sqlTrade, $paramsTrade);

        if ($stmtTrade === false) {
            $errors = sqlsrv_errors();
            $message = "Eroare la inserarea trade-ului: " . print_r($errors, true);
        } else {
            // 2. Actualizare poziții
            // Verifică dacă există poziție deschisă pentru portofoliu și instrument
            $sqlCheck = "SELECT position_id, quantity, avg_entry_price FROM positions WHERE portfolio_id = ? AND instrument = ? AND closed_date IS NULL";
            $paramsCheck = [$portfolio_id, $instrument];
            $stmtCheck = sqlsrv_query($conn, $sqlCheck, $paramsCheck);

            if ($stmtCheck === false) {
                $errors = sqlsrv_errors();
                $message = "Eroare la verificarea poziției: " . print_r($errors, true);
            } else {
                $position = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);

                if ($position) {
                    // Actualizare poziție existentă
                    // Pentru BUY creștem cantitatea și recalculăm prețul mediu
                    // Pentru SELL scădem cantitatea (simplificat, fără gestionare poziție negativă)
                    if ($side === 'BUY') {
                        $newQuantity = $position['quantity'] + $quantity;
                        $newAvgPrice = (($position['avg_entry_price'] * $position['quantity']) + ($price * $quantity)) / $newQuantity;
                    } else { // SELL
                        $newQuantity = $position['quantity'] - $quantity;
                        $newAvgPrice = $position['avg_entry_price']; // prețul mediu rămâne la fel (sau recalculat după nevoie)
                        if ($newQuantity < 0) {
                            $message = "Eroare: Nu poți vinde mai mult decât deții.";
                            goto end;
                        }
                    }

                    $sqlUpdate = "UPDATE positions SET quantity = ?, avg_entry_price = ? WHERE position_id = ?";
                    $paramsUpdate = [$newQuantity, $newAvgPrice, $position['position_id']];
                    $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

                    if ($stmtUpdate === false) {
                        $errors = sqlsrv_errors();
                        $message = "Eroare la actualizarea poziției: " . print_r($errors, true);
                    } else {
                        $message = "Trade adăugat și poziția actualizată cu succes!";
                    }
                } else {
                    // Creare poziție nouă doar pentru BUY
                    if ($side === 'BUY') {
                        $sqlInsert = "INSERT INTO positions (portfolio_id, instrument, quantity, avg_entry_price, open_date) VALUES (?, ?, ?, ?, GETDATE())";
                        $paramsInsert = [$portfolio_id, $instrument, $quantity, $price];
                        $stmtInsert = sqlsrv_query($conn, $sqlInsert, $paramsInsert);

                        if ($stmtInsert === false) {
                            $errors = sqlsrv_errors();
                            $message = "Eroare la crearea poziției: " . print_r($errors, true);
                        } else {
                            $message = "Trade adăugat și poziția creată cu succes!";
                        }
                    } else {
                        $message = "Eroare: Nu există poziție deschisă pentru a vinde.";
                    }
                }
            }
        }
    }
}

end:
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Trade with Alpha Vantage</title>
    <link rel="stylesheet" href="../../css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="body">

    <h2 class="section-title">Add new trade </h2>

    <?php if (!empty($message)): ?>
        <div class="<?= strpos($message, 'Error') === false ? 'message' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="trade-form" style="max-width:600px;margin:auto;" novalidate>
        <div class="form-grid">
            <div class="form-group">
                <label for="portfolio_id">Portfolio</label>
                <select id="portfolio_id" name="portfolio_id" class="form-control" required>
                    <option value="">Select Portfolio</option>
                    <?php
                    if ($portfolio_result) {
                        while ($portfolio = sqlsrv_fetch_array($portfolio_result, SQLSRV_FETCH_ASSOC)) {
                            echo '<option value="' . $portfolio['portfolio_id'] . '">' . htmlspecialchars($portfolio['portfolio_name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="instrument">Instrument</label>
                <select id="instrument" name="instrument" class="form-control" required>
                    <option value="">Select instrument</option>
                    <?php foreach ($instruments as $name => $symbol): ?>
                        <option value="<?= htmlspecialchars($symbol) ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="price" class="price-display" style="margin-top:8px;font-weight:500;color:var(--color-teal);">
                    Select an instrument to view price
                </div>
                <input type="hidden" id="price_input" name="price" required>
            </div>

            <div class="form-group">
                <label for="counterparty_id">Counterparty</label>
                <select id="counterparty_id" name="counterparty_id" class="form-control" required>
                    <option value="">Select counterparty</option>
                    <?php
                    if ($counterparty_result) {
                        while ($cp = sqlsrv_fetch_array($counterparty_result, SQLSRV_FETCH_ASSOC)) {
                            echo '<option value="' . $cp['counterparty_id'] . '">' . htmlspecialchars($cp['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="trade_date">Transaction Date</label>
                <input type="datetime-local" id="trade_date" name="trade_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="settlement_date">Settlement Date</label>
                <input type="datetime-local" id="settlement_date" name="settlement_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="side">Trade type</label>
                <select id="side" name="side" class="form-control" required>
                    <option value="BUY">BUY</option>
                    <option value="SELL">SELL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" step="0.01" min="0.01" required>
            </div>

            <div class="form-group">
                <label for="currency">Currency (ex: USD)</label>
                <input type="text" id="currency" name="currency" class="form-control" maxlength="3" required>
            </div>
        </div>
        <button type="submit" class="submit-btn" style="margin-top:10px;">Add Trade</button>
    </form>

    <br>
    <a href="../../dashboard.php" class="submit-btn" style="max-width: 200px; display: inline-block;">Back to Dashboard</a>

    <script>
    $(document).ready(function() {
        $('#instrument').change(function() {
            let symbol = $(this).val();
            if (!symbol) {
                $('#price').text('Select an instrument to view price');
                $('#price_input').val('');
                return;
            }
            $.ajax({
                url: 'get_price.php',
                method: 'GET',
                data: { symbol: symbol },
                dataType: 'json',
                success: function(response) {
                    if (response.price !== null) {
                        $('#price').text('Current price: ' + response.price + ' USD');
                        $('#price_input').val(response.price);
                    } else {
                        $('#price').text('Could not get price.');
                        $('#price_input').val('');
                    }
                },
                error: function() {
                    $('#price').text('Error at price retrieval.');
                    $('#price_input').val('');
                }
            });
        });
    });
    </script>
</body>
</html>