<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$test_id = $_GET['test_id'];

// ✅ Test Result Fetch Query
$query = "SELECT score, result_type, career_recommendation, completed_at 
          FROM test_results 
          WHERE user_id = ? AND test_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $test_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $score = $row['score'];
    $result_type = $row['result_type'];
    $career_suggestion = $row['career_recommendation'];
    $completed_at = $row['completed_at'];
} else {
    $score = "N/A";
    $result_type = "N/A";
    $career_suggestion = "No suggestion available";
    $completed_at = "N/A";
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Test Result</h2>
    <div class="result-card">
        <p><strong>Score:</strong> <?php echo htmlspecialchars($score); ?></p>
        <p><strong>Result Type:</strong> <?php echo htmlspecialchars($result_type); ?></p>
        <p><strong>Career Suggestion:</strong> <?php echo htmlspecialchars($career_suggestion); ?></p>
        <p><strong>Completed At:</strong> <?php echo htmlspecialchars($completed_at); ?></p>
    </div>

    <!-- ✅ Back to Dashboard Button -->
    <a href="../users/dashboard.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html>
<style>
   body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 600px;
    margin: 50px auto;
    padding: 25px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.result-card {
    background-color: #fafafa;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 20px;
}

.result-card p {
    font-size: 16px;
    color: #555;
    margin: 8px 0;
}

.btn {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    margin-top: 12px;
    transition: background-color 0.2s ease-in-out;
}

.btn:hover {
    background-color: #45a049;
}
 
</style> 
