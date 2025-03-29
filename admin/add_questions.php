<?php
session_start();
include('../includes/db.php');

// Admin ko check karo
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Test ID ko check karo
if (!isset($_GET['test_id'])) {
    echo "Test ID is missing!";
    exit();
}

$test_id = $_GET['test_id'];

// Question ko insert karo
if (isset($_POST['add'])) {
    $question_text = $_POST['question_text'];
    $option_1 = $_POST['option_1'];
    $option_2 = $_POST['option_2'];
    $option_3 = $_POST['option_3'];
    $option_4 = $_POST['option_4'];
    $correct_option = $_POST['correct_option'];

    $insert_query = "INSERT INTO questions (test_id, question_text, option_1, option_2, option_3, option_4, correct_option) 
                    VALUES ('$test_id', '$question_text', '$option_1', '$option_2', '$option_3', '$option_4', '$correct_option')";

    if ($conn->query($insert_query)) {
        echo "<script>alert('Question added successfully!'); window.location='manage_questions.php?test_id=$test_id';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question</title>
</head>
<body>
    <h2>Add New Question</h2>
    <form method="POST">
        <label>Question Text:</label>
        <textarea name="question_text" required></textarea><br>

        <label>Option 1:</label>
        <input type="text" name="option_1" required><br>

        <label>Option 2:</label>
        <input type="text" name="option_2" required><br>

        <label>Option 3:</label>
        <input type="text" name="option_3" required><br>

        <label>Option 4:</label>
        <input type="text" name="option_4" required><br>

        <label>Correct Option:</label>
        <input type="text" name="correct_option" required><br>

        <button type="submit" name="add">Add Question</button>
    </form>
</body>
</html>
