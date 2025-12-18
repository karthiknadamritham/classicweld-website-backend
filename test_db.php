<?php
$host = '127.0.0.1';
$db   = 'classicweld';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "SUCCESS: Connected to database '$db' successfully!";
} catch (\PDOException $e) {
     echo "FAILURE: Could not connect.\n";
     echo "Error Message: " . $e->getMessage() . "\n";
     echo "Code: " . $e->getCode();
}
