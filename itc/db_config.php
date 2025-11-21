<?php
// db_config.php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "Institutional Trading Center",
    "Uid" => "admin", // Using admin credentials for database connection
    "PWD" => "parola1"
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}
?>