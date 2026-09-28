<?php
declare(strict_types=1);

/** Get one reusable PDO connection per request. */
function database(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $config = require __DIR__ . '/../config/database.php';
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['host'],
        $config['port'],
        $config['name']
    );

    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Match the schema's UTC timestamp convention.
    $pdo->exec("SET time_zone = '+00:00'");
    $connection = $pdo;

    return $connection;
}
