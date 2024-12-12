<?php
include 'functions.php';
include 'db.php';
redirectIfNotLoggedIn();

$stmt = $pdo->query("SELECT * FROM activity_logs ORDER BY created_at DESC");
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Activity Logs</title>
</head>
<body>
    <h1>Activity Logs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Action</th>
                <th>Details</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['username']); ?></td>
                <td><?php echo htmlspecialchars($log['action']); ?></td>
                <td><?php echo htmlspecialchars($log['details']); ?></td>
                <td><?php echo htmlspecialchars($log['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php">Back to Dashboard</a>
</body>
</html>
