<?php
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');


$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

$migrationFiles = glob(__DIR__ . '/migrations/*.sql');

foreach ($migrationFiles as $migrationFile) {
    $sql = file_get_contents($migrationFile);
    $pdo->exec($sql);
    echo "Executed migration: $migrationFile\n";
}


