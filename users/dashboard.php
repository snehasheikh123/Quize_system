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
    <style>
        /* Basic Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
            overflow-x: hidden;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #ffffff;
            transition: margin-left 0.3s ease;
            margin-left: 250px;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Profile Info */
        .profile-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ecf0f1;
        }

        .profile-info h1 {
            font-size: 22px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .profile-info p {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Edit Profile Button */
        .edit-profile-btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-weight: 500;
        }

        .edit-profile-btn:hover {
            background-color: #2980b9;
        }

        /* Dashboard Overview */
        .dashboard-overview {
            background-color: #fafafa;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
            text-align: center;
        }

        .dashboard-overview h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .dashboard-overview p {
            font-size: 14px;
            color: #7f8c8d;
            line-height: 1.6;
        }

        /* Responsive Changes */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .profile-info {
                flex-direction: column;
            }

            .edit-profile-btn {
                width: 100%;
                max-width: 180px;
            }

            .dashboard-overview {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<!-- Include Sidebar -->
<?php include('../includes/sidebar.php'); ?>

<!-- Main Content -->
<div class="main-content" id="main-content">
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

    <!-- Dashboard Overview -->
    <div class="dashboard-overview">
        <h2>Your Dashboard Overview</h2>
        <p>Welcome to your career guidance portal. Get started with the available tests and career suggestions.</p>
    </div>
</div>

</body>
</html>
