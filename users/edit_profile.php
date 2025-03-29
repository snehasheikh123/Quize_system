<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ User details ko fetch karo
$query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$success = '';
$error = '';

// ✅ Form submit hone par data update karo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $profile_image = $user['profile_image'];

    // ✅ Profile photo upload handling
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../assets/uploads/";
        $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // ✅ Allowed file types and size check
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) { // 2 MB limit
            $error = "File size should not exceed 2MB.";
        } else {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                // ✅ Old photo delete karo (agar default nahi hai)
                if ($user['profile_image'] && $user['profile_image'] !== 'default.png') {
                    unlink($target_dir . $user['profile_image']);
                }
                $profile_image = $file_name;
            } else {
                $error = "Failed to upload file.";
            }
        }
    }

    // ✅ Agar koi error nahi hai to data update karo
    if (!$error) {
        $update_query = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, profile_image = ? WHERE user_id = ?");
        $update_query->bind_param('ssssi', $first_name, $last_name, $email, $profile_image, $user_id);

        if ($update_query->execute()) {
            $success = "Profile updated successfully!";

            // ✅ Updated session data
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['profile_image'] = $profile_image;

            // ✅ User ko redirect karo taaki naye data show ho
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .profile-preview {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-preview img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .back-link {
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        .message {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>

    <!-- ✅ Success/Error Message -->
    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="profile-preview">
        <img id="preview" src="../assets/uploads/<?php echo $user['profile_image'] ?: 'default.png'; ?>" alt="Profile Photo">
    </div>

    <form method="POST" enctype="multipart/form-data">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Profile Photo</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="previewImage(event)">

        <button type="submit">Save Changes</button>
    </form>

    <div class="back-link">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

</body>
</html>
