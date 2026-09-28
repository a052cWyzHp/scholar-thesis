<?php
declare(strict_types=1);

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function input_text(array $input, string $key): string
{
    return isset($input[$key]) && is_string($input[$key]) ? trim($input[$key]) : '';
}

function start_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start([
            'use_strict_mode' => true,
            'use_only_cookies' => true,
            'cookie_httponly' => true,
            'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'cookie_samesite' => 'Lax',
        ]);
    }
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function valid_csrf_token(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
