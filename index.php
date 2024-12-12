<?php
include 'functions.php';
redirectIfNotLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <a href="applicants.php">Manage Applicants</a>
    <a href="activity_logs.php">View Activity Logs</a>
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>
