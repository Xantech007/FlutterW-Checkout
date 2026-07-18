<?php
// dbcon.php
$host = 'sql204.infinityfree.com';
$db   = 'if0_42438090_db';
$user = 'if0_42438090'; // Change to your server database user profile
$pass = 'oH31LBO6lSF3XxV';     // Change to your server database password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Production setup should log errors silently rather than printing raw stack data
     die(json_encode(['valid' => false, 'error' => 'Database connection failed.']));
}
?>

