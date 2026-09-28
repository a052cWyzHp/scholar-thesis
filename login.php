<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

start_session();
header('Cache-Control: no-store');
$email = '';
$errors = [];
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = input_text($_POST, 'email');
    // Password spaces are significant; never trim or repopulate passwords.
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

    if (!valid_csrf_token(input_text($_POST, 'csrf_token'))) {
        http_response_code(403);
        $errors[] = 'Your form expired. Please submit it again.';
    } else {
        $errors = validate_login($email, $password);
        if ($errors === []) {
            authenticate_user($email, $password);
            $notice = 'Login is not available yet. Authentication will be connected in a future update.';
        } else {
            http_response_code(422);
        }
    }
    unset($password);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | S.C.H.O.L.A.R.</title>
</head>
<body>
    <main>
        <h1>S.C.H.O.L.A.R. Login</h1>
        <p>Administrator login. Authentication is not connected yet.</p>
        <?php if ($errors !== []): ?>
            <ul role="alert">
                <?php foreach ($errors as $error): ?>
                    <li><?= escape($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if ($notice !== ''): ?>
            <p role="status"><?= escape($notice) ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" value="<?= escape($email) ?>" maxlength="254" autocomplete="username" required>
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </p>
            <button type="submit">Log in</button>
        </form>
        <p><a href="dashboard.php">Preview dashboard</a> (no login required during development)</p>
    </main>
</body>
</html>
