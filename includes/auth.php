<?php
declare(strict_types=1);

function validate_login(string $email, string $password): array
{
    $errors = [];
    if ($email === '' || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($password === '') {
        $errors[] = 'Enter your password.';
    }
    return $errors;
}

function authenticate_user(string $email, string $password): ?array
{
    // TODO: Database lookup intentionally blank.
    // Later: prepared user lookup, active user/role checks, and password_verify().
    // After verification: regenerate the session ID and store only the user ID.
    return null;
}
