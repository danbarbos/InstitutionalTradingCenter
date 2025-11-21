<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once '../db_config.php';

$message = "";

// Adăugare contrapartid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = trim($_POST['counterparty_name']);
    $type = trim($_POST['counterparty_type']);
    $country = trim($_POST['country']);
    $rating = trim($_POST['rating']);

    if ($name && $type && $country && $rating) {
        $sql = "INSERT INTO counterparties (name, type, country, rating) VALUES (?, ?, ?, ?)";
        $params = [$name, $type, $country, $rating];
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt) {
            $message = "Counterparty added!";
        } else {
            $message = "Error: " . print_r(sqlsrv_errors(), true);
        }
    } else {
        $message = "Complete all fields!";
    }
}

// Ștergere contrapartid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $sql = "DELETE FROM counterparties WHERE counterparty_id = ?";
    $params = [$id];
    $stmt = sqlsrv_query($conn, $sql, $params);
    $message = $stmt ? "Counterparty deleted!" : "Error: " . print_r(sqlsrv_errors(), true);
}

// Editare contrapartid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['edit']);
    $name = trim($_POST['counterparty_name']);
    $type = trim($_POST['counterparty_type']);
    $country = trim($_POST['country']);
    $rating = trim($_POST['rating']);

    if ($id && $name && $type && $country && $rating) {
        $sql = "UPDATE counterparties SET name = ?, type = ?, country = ?, rating = ? WHERE counterparty_id = ?";
        $params = [$name, $type, $country, $rating, $id];
        $stmt = sqlsrv_query($conn, $sql, $params);
        $message = $stmt ? "Counterparty updated!" : "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        $message = "Complete all fields!";
    }
}

// Preluare contrapartide pentru tabel
$sql = "SELECT counterparty_id, name, type, country, rating FROM counterparties ORDER BY counterparty_id DESC";
$stmt = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <title>Manage Counterparties</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/style.css" />
    <script>
        function showEditForm(id) {
            document.querySelectorAll('.edit-form').forEach(f => f.style.display = 'none');
            document.getElementById('edit-form-' + id).style.display = 'block';
            window.scrollTo({top: document.getElementById('edit-form-' + id).offsetTop - 20, behavior: 'smooth'});
        }
        function hideEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'none';
        }
    </script>
</head>
<body class="with-bg-image">

<main>
    <h2 class="section-title">Manage Counterparties</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Formular adăugare -->
    <form method="POST" class="trade-form" style="max-width:500px;margin-bottom:30px;">
        <div class="form-group">
            <label for="counterparty_name">Counterparty Name</label>
            <input type="text" name="counterparty_name" id="counterparty_name" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="counterparty_type">Counterparty Type</label>
            <input type="text" name="counterparty_type" id="counterparty_type" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="text" name="rating" id="rating" class="form-control" required />
        </div>
        <button type="submit" name="add" class="submit-btn">Add Counterparty</button>
    </form>

    <!-- Tabel counterparties -->
    <div class="trades-table-container">
        <table class="trades-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Country</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $row['counterparty_id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['type']) ?></td>
                        <td><?= htmlspecialchars($row['country']) ?></td>
                        <td><?= htmlspecialchars($row['rating']) ?></td>
                        <td>
                            <button type="button" class="submit-btn" style="background:var(--color-teal);" onclick="showEditForm(<?= $row['counterparty_id'] ?>)">
                                <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path fill="#fff" d="M1 11.9l-1 4.1 4.1-1 9.2-9.2-3.1-3.1-9.2 9.2zM1.5 15l-0.4-0.5 0.4-2 2 2-2 0.5zM10.9 4.4l-8.1 8-0.6-0.6 8.1-8 0.6 0.6z"></path>
                                    <path fill="#fff" d="M15.3 0.7c-1.1-1.1-2.6-0.5-2.6-0.5l-1.5 1.5 3.1 3.1 1.5-1.5c0-0.1 0.6-1.5-0.5-2.6zM13.4 1.6l-0.5-0.5c0.6-0.6 1.1-0.1 1.1-0.1l-0.6 0.6z"></path>
                                </svg>
                            </button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this counterparty?');">
                                <input type="hidden" name="delete" value="<?= $row['counterparty_id'] ?>" />
                                <button type="submit" class="submit-btn" style="background:var(--color-darkest);margin-left:5px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 1 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <form method="POST" class="trade-form edit-form" id="edit-form-<?= $row['counterparty_id'] ?>" style="display:none;max-width:900px;margin:20px auto;">
                                <input type="hidden" name="edit" value="<?= $row['counterparty_id'] ?>" />
                                <div class="form-group">
                                    <label for="counterparty_name_<?= $row['counterparty_id'] ?>">Counterparty Name</label>
                                    <input type="text" name="counterparty_name" id="counterparty_name_<?= $row['counterparty_id'] ?>" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="counterparty_type_<?= $row['counterparty_id'] ?>">counterparty Type</label>
                                    <input type="text" name="counterparty_type" id="counterparty_type_<?= $row['counterparty_id'] ?>" class="form-control" value="<?= htmlspecialchars($row['type']) ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="country_<?= $row['counterparty_id'] ?>">Country</label>
                                    <input type="text" name="country" id="country_<?= $row['counterparty_id'] ?>" class="form-control" value="<?= htmlspecialchars($row['country']) ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="rating_<?= $row['counterparty_id'] ?>">Regulatory ID</label>
                                    <input type="text" name="rating" id="rating_<?= $row['counterparty_id'] ?>" class="form-control" value="<?= htmlspecialchars($row['rating']) ?>" required />
                                </div>
                                <button type="submit" class="submit-btn">Save Changes</button>
                                <button type="button" class="submit-btn" style="background:var(--color-darkest);margin-left:5px;" onclick="hideEditForm(<?= $row['counterparty_id'] ?>)">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<style>
        .button {
        background-color: #04AA6D;
        border: none;
        color: white;
        padding: 16px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        }

            .button1 {
            background-color: white; 
            color: black; 
            border: 2px solid #4B868D;
            }

            .button1:hover {
            background-color: #4B868D;
            color: white;
            }
    </style>

    <br>
    <a href="../dashboard.php" class="button button1"> Back to Dashboard</a>


</body>
</html>
