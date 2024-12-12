<?php
function logActivity($pdo, $username, $action, $details) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (username, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$username, $action, $details]);
}

function redirectIfNotLoggedIn() {
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
}
?>
