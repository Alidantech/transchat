<?php
$dbHost = 'localhost';
$dbUser = 'username';
$dbPass = 'password';
$dbName = 'database_name';

$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

$migrationFiles = glob(__DIR__ . '/migrations/*.sql');

foreach ($migrationFiles as $migrationFile) {
    $sql = file_get_contents($migrationFile);
    $pdo->exec($sql);
    echo "Executed migration: $migrationFile\n";
}
