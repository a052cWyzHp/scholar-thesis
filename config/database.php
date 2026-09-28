<?php
declare(strict_types=1);

// Defaults are for local XAMPP development only.
// Environment variables override these values, including an empty password.
return [
    'host' => getenv('DB_HOST') !== false ? getenv('DB_HOST') : '127.0.0.1',
    'port' => getenv('DB_PORT') !== false ? getenv('DB_PORT') : '3306',
    'name' => getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'scholar',
    'username' => getenv('DB_USER') !== false ? getenv('DB_USER') : 'root',
    'password' => getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '',
];
