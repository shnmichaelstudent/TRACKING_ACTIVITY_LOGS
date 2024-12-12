<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position_applied = $_POST['position_applied'];
    $created_by = $_SESSION['user_id'];

    $query = $pdo->prepare("INSERT INTO applicants (name, email, phone, position_applied, created_by) VALUES (?, ?, ?, ?, ?)");
    if ($query->execute([$name, $email, $phone, $position_applied, $created_by])) {
        // Log activity
        $log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'INSERT', ?)");
        $log->execute([$_SESSION['user_id'], "Created applicant: $name"]);

        header('Location: index.php');
    } else {
        echo "Error: Unable to create applicant.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Applicant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="create-container">
        <h1>Create New Applicant</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="text" name="position_applied" placeholder="Position Applied" required>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>
