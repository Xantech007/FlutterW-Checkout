<?php
// Extracted from your connection config
$databaseURL = "https://smp-9jacash-default-rtdb.firebaseio.com";

// Append .json to the root to read the entire tree
$url = $databaseURL . "/.json";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    
    // Print the structure (Nodes act as tables, keys act as columns)
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

curl_close($ch);
?>
