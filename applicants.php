<?php
include 'functions.php';
include 'db.php';
redirectIfNotLoggedIn();

// Handle form submissions for Create, Update, and Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];

    if (isset($_POST['add_applicant'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $position = $_POST['position'];

        $stmt = $pdo->prepare("INSERT INTO applicants (name, email, phone, address, applied_position, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $address, $position, $username]);

        logActivity($pdo, $username, "INSERT", "Added new applicant: $name");
        header("Location: applicants.php");
        exit();
    }

    if (isset($_POST['update_applicant'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $position = $_POST['position'];

        $stmt = $pdo->prepare("UPDATE applicants SET name = ?, email = ?, phone = ?, address = ?, applied_position = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $address, $position, $id]);

        logActivity($pdo, $username, "UPDATE", "Updated applicant ID: $id");
        header("Location: applicants.php");
        exit();
    }

    if (isset($_POST['delete_applicant'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM applicants WHERE id = ?");
        $stmt->execute([$id]);

        logActivity($pdo, $username, "DELETE", "Deleted applicant ID: $id");
        header("Location: applicants.php");
        exit();
    }
}

// Handle search
$searchQuery = '';
$applicants = [];
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? OR address LIKE ? OR applied_position LIKE ?");
    $stmt->execute(["%$searchQuery%", "%$searchQuery%", "%$searchQuery%", "%$searchQuery%", "%$searchQuery%"]);
    $applicants = $stmt->fetchAll();

    logActivity($pdo, $_SESSION['username'], "SEARCH", "Searched for: $searchQuery");
} else {
    $stmt = $pdo->query("SELECT * FROM applicants");
    $applicants = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Applicants</title>
</head>
<body>
    <h1>Manage Applicants</h1>
    <form method="GET" action="applicants.php">
        <input type="text" name="search" placeholder="Search applicants" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>

    <form method="POST" action="applicants.php">
        <h2>Add New Applicant</h2>
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="position" placeholder="Applied Position" required>
        <button type="submit" name="add_applicant">Add Applicant</button>
    </form>

    <h2>Applicant List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Position</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applicants as $applicant): ?>
            <tr>
                <td><?php echo htmlspecialchars($applicant['name']); ?></td>
                <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                <td><?php echo htmlspecialchars($applicant['phone']); ?></td>
                <td><?php echo htmlspecialchars($applicant['address']); ?></td>
                <td><?php echo htmlspecialchars($applicant['applied_position']); ?></td>
                <td><?php echo htmlspecialchars($applicant['created_by']); ?></td>
                <td>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $applicant['id']; ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($applicant['name']); ?>" required>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($applicant['email']); ?>" required>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($applicant['phone']); ?>" required>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($applicant['address']); ?>" required>
                        <input type="text" name="position" value="<?php echo htmlspecialchars($applicant['applied_position']); ?>" required>
                        <button type="submit" name="update_applicant">Update</button>
                    </form>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $applicant['id']; ?>">
                        <button type="submit" name="delete_applicant">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php">Back to Dashboard</a>
</body>
</html>
