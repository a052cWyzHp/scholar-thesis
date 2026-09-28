<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/theses.php';

// TODO: Require authentication and authorization before connecting real data.
// This is currently an empty, public development preview.
header('Cache-Control: no-store');
$filters = [];
foreach (['search', 'year', 'department', 'program', 'status'] as $field) {
    $filters[$field] = input_text($_GET, $field);
}
$errors = [];
if ($filters['year'] !== '' && !preg_match('/^[1-9][0-9]{3}$/D', $filters['year'])) {
    $errors[] = 'Enter a four-digit year between 1000 and 9999, or leave it blank.';
    http_response_code(422);
}
$theses = $errors === [] ? find_theses($filters) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | S.C.H.O.L.A.R.</title>
</head>
<body>
    <main>
        <h1>S.C.H.O.L.A.R. Dashboard</h1>
        <p>Development preview. Records and database filtering are not connected yet.</p>
        <p><a href="login.php">Back to login</a></p>
        <?php if ($errors !== []): ?>
            <ul role="alert">
                <?php foreach ($errors as $error): ?>
                    <li><?= escape($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form method="get" action="dashboard.php">
            <fieldset>
                <legend>Filter thesis records</legend>
                <p>
                    <label for="search">Title, author, or keyword</label><br>
                    <input type="search" id="search" name="search" value="<?= escape($filters['search']) ?>">
                </p>
                <p>
                    <label for="year">Publication year</label><br>
                    <input type="number" id="year" name="year" min="1000" max="9999" step="1" value="<?= escape($filters['year']) ?>">
                </p>
                <?php foreach (['department' => 'Department', 'program' => 'Program', 'status' => 'Workflow status'] as $field => $label): ?>
                    <p>
                        <label for="<?= escape($field) ?>"><?= escape($label) ?></label><br>
                        <input type="text" id="<?= escape($field) ?>" name="<?= escape($field) ?>" value="<?= escape($filters[$field]) ?>">
                    </p>
                <?php endforeach; ?>
                <!-- TODO: Populate department, program, and status options once confirmed. -->
                <button type="submit">Apply filters</button>
                <a href="dashboard.php">Clear filters</a>
            </fieldset>
        </form>
        <h2>Thesis records</h2>
        <table>
            <caption>Thesis lookup results</caption>
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Year</th>
                    <th scope="col">Department</th>
                    <th scope="col">Program</th>
                    <th scope="col">Workflow status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($theses === []): ?>
                    <tr><td colspan="6">No records to display. Database lookup will be added later.</td></tr>
                <?php else: ?>
                    <?php foreach ($theses as $thesis): ?>
                        <tr>
                            <?php foreach (['title', 'authors', 'publication_year', 'department', 'program', 'workflow_status'] as $column): ?>
                                <td><?= escape((string) ($thesis[$column] ?? '')) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- TODO: Add pagination after database integration. -->
    </main>
</body>
</html>
