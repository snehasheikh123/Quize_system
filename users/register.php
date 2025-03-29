<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Password hashing
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // File Upload (Profile Image)
    $profile_image = '';
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../assets/uploads/";
        $profile_image = time() . '_' . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $profile_image;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            echo "Failed to upload profile image.";
        }
    }

    $query = "INSERT INTO users (first_name, last_name, email, password, dob, gender, profile_image, created_at) 
              VALUES ('$first_name', '$last_name', '$email', '$password', '$dob', '$gender', '$profile_image', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="date" name="dob" required><br>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>
        <input type="file" name="profile_image" accept="image/*"><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
