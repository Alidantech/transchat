<?php
// Include the database configuration
include('config.php');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $migrationFiles = glob(__DIR__ . '\migrations\*.sql');

    foreach ($migrationFiles as $migrationFile) {
        $sql = file_get_contents($migrationFile);
        $pdo->exec($sql);
        echo "Executed migration: $migrationFile\n";
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
