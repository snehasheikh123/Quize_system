<?php
session_start();
include('../includes/db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin credentials from database
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: manage_tests.php'); // Redirect to admin panel
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<h2>Admin Login</h2>
<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit" name="login">Login</button>
</form>

<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
