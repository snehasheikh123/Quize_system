<?php
session_start();
include('../includes/db.php');

// Admin ko check karo
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Test ko fetch karo
if (isset($_GET['test_id'])) {
    $test_id = $_GET['test_id'];
    $query = "SELECT * FROM personality_tests WHERE test_id = $test_id";
    $result = $conn->query($query);
    $test = $result->fetch_assoc();

    if (!$test) {
        echo "Test not found!";
        exit();
    }
}

// Test ko update karo
if (isset($_POST['update'])) {
    $test_name = $_POST['test_name'];
    $description = $_POST['description'];

    $update_query = "UPDATE personality_tests SET 
        test_name = '$test_name', 
        description = '$description' 
        WHERE test_id = $test_id";

    if ($conn->query($update_query)) {
        echo "<script>alert('Test updated successfully!'); window.location='manage_tests.php';</script>";
    } else {
        echo "Error updating test: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Test</title>
</head>
<body>
    <h2>Edit Test</h2>
    <form method="POST">
        <label>Test Name:</label>
        <input type="text" name="test_name" value="<?php echo $test['test_name']; ?>" required><br>
        
        <label>Description:</label>
        <textarea name="description" required><?php echo $test['description']; ?></textarea><br>
        
        <button type="submit" name="update">Update Test</button>
    </form>
</body>
</html>
