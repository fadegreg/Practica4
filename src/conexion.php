<?php

$host     = getenv('DB_HOST');
$port     = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$sslmode  = getenv('DB_SSLMODE') ?: 'prefer';

$dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=$sslmode";

try {
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Error al conectar con la base de datos.');
}