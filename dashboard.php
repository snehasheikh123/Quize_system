<?php
session_start();
include('../includes/db.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT first_name, last_name, email, profile_image FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
$user_name = $user_name ?: 'User';

$email = $user['email'] ?? 'Not available';
$profile_photo = !empty($user['profile_image']) ? '../assets/uploads/' . $user['profile_image'] : '../assets/uploads/default.png';

if (!file_exists($profile_photo)) {
    $profile_photo = '../assets/uploads/default.png';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<!-- Include Sidebar -->
<?php include('../includes/sidebar.php'); ?>

<!-- Main Content -->
<div class="main-content">
    <header>
        <div class="profile-info">
            <img src="<?php echo $profile_photo; ?>" alt="Profile Photo">
            <div>
                <h1>Welcome, <?php echo $user_name; ?>!</h1>
                <p><?php echo $email; ?></p>
            </div>
        </div>
        <a href="edit_profile.php">
            <button class="edit-profile-btn">Edit Profile</button>
        </a>
    </header>

    <h2>Your Dashboard Overview</h2>
    <p>Welcome to your career guidance portal. Get started with the available tests and career suggestions.</p>
</div>

</body>
</html>
