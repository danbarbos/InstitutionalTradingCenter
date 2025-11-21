<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$apiKey = '2UETONNIRXMKTS3Q'; // Folosește cheia ta Alpha Vantage

if (!isset($_GET['symbol']) || empty($_GET['symbol'])) {
    echo json_encode(['price' => null, 'error' => 'Simbol lipsă']);
    exit();
}

$symbol = $_GET['symbol'];

$cacheDir = __DIR__ . '/cache';
if (!is_dir($cacheDir) && !mkdir($cacheDir, 0755, true) && !is_dir($cacheDir)) {
    echo json_encode(['price' => null, 'error' => 'Nu s-a putut crea folderul cache']);
    exit();
}

$cacheFile = $cacheDir . '/' . md5($symbol) . '.json';
$cacheTTL = 600; // 10 minute

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTTL) {
    $cachedData = file_get_contents($cacheFile);
    if ($cachedData !== false) {
        echo $cachedData;
        exit();
    }
}

function getAlphaVantagePrice($symbol, $apikey) {
    $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=" . urlencode($symbol) . "&apikey=" . $apikey;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('Eroare cURL: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }
    curl_close($ch);

    $data = json_decode($response, true);
    return $data['Global Quote']['05. price'] ?? null;
}

$price = getAlphaVantagePrice($symbol, $apiKey);

if ($price === null) {
    $response = ['price' => null, 'error' => 'Nu s-a putut prelua prețul'];
} else {
    $response = ['price' => $price];
    file_put_contents($cacheFile, json_encode($response));
}

echo json_encode($response);
