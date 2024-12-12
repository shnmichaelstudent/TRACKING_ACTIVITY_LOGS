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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position_applied = $_POST['position_applied'];

        $updateQuery = $pdo->prepare("UPDATE applicants SET name = ?, email = ?, phone = ?, position_applied = ?, updated_at = NOW() WHERE id = ?");
        if ($updateQuery->execute([$name, $email, $phone, $position_applied, $id])) {
            // Log activity
            $log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'UPDATE', ?)");
            $log->execute([$_SESSION['user_id'], "Updated applicant: $name"]);

            header('Location: index.php');
        } else {
            echo "Error: Unable to update applicant.";
        }
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Applicant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="edit-container">
        <h1>Edit Applicant</h1>
        <form method="POST">
            <input type="text" name="name" value="<?php echo $applicant['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $applicant['email']; ?>" required>
            <input type="text" name="phone" value="<?php echo $applicant['phone']; ?>" required>
            <input type="text" name="position_applied" value="<?php echo $applicant['position_applied']; ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
