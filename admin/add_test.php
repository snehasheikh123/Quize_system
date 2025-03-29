<?php
session_start();
include('../includes/db.php');

// Admin login check
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Form submit hone par naya test add karo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_name = $_POST['test_name'];
    $description = $_POST['description'];

    $query = "INSERT INTO personality_tests (test_name, description) VALUES ('$test_name', '$description')";
    $conn->query($query);

    header('Location: manage_tests.php');
    exit();
}
?>

<h2>Add New Test</h2>
<form method="POST">
    <label>Test Name:</label>
    <input type="text" name="test_name" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <button type="submit">Add Test</button>
</form>
