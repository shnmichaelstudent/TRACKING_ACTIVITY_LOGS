<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the applicant details
    $query = $pdo->prepare("SELECT * FROM applicants WHERE id = ?");
    $query->execute([$id]);
    $applicant = $query->fetch();

    if (!$applicant) {
        echo "Applicant not found.";
        exit();
    }

    // Delete applicant
    $deleteQuery = $pdo->prepare("DELETE FROM applicants WHERE id = ?");
    if ($deleteQuery->execute([$id])) {
        // Log activity
        $log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'DELETE', ?)");
        $log->execute([$_SESSION['user_id'], "Deleted applicant: $applicant[name]"]);

        header('Location: index.php');
    } else {
        echo "Error: Unable to delete applicant.";
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
