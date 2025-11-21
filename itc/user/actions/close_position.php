<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['position_id'])) {
    $position_id = intval($_POST['position_id']);
    $closed_date = date('Y-m-d H:i:s');

    $sql = "UPDATE dbo.positions SET closed_date = ? WHERE position_id = ?";
    $params = [$closed_date, $position_id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $errors = sqlsrv_errors();
        $_SESSION['message'] = "Error when trying to close position: " . print_r($errors, true);
    } else {
        $_SESSION['message'] = "The position was succesfully closed.";
    }
} else {
    $_SESSION['message'] = "Invalid Data.";
}

header("Location: positions.php");
exit();
