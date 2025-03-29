<?php
session_start();
include('../includes/db.php');

// Admin ko check karo
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Question ko fetch karo
if (isset($_GET['question_id'])) {
    $question_id = $_GET['question_id'];
    $query = "SELECT * FROM questions WHERE question_id = $question_id";
    $result = $conn->query($query);
    $question = $result->fetch_assoc();

    if (!$question) {
        echo "Question not found!";
        exit();
    }
}

// Question ko update karo
if (isset($_POST['update'])) {
    $question_text = $_POST['question_text'];
    $option_1 = $_POST['option_1'];
    $option_2 = $_POST['option_2'];
    $option_3 = $_POST['option_3'];
    $option_4 = $_POST['option_4'];
    $correct_option = $_POST['correct_option'];

    $update_query = "UPDATE questions SET 
        question_text = '$question_text',
        option_1 = '$option_1',
        option_2 = '$option_2',
        option_3 = '$option_3',
        option_4 = '$option_4',
        correct_option = '$correct_option'
        WHERE question_id = $question_id";

    if ($conn->query($update_query)) {
        echo "<script>alert('Question updated successfully!'); window.location='manage_questions.php?test_id={$question['test_id']}';</script>";
    } else {
        echo "Error updating question: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question</title>
</head>
<body>
    <h2>Edit Question</h2>
    <form method="POST">
        <label>Question Text:</label>
        <textarea name="question_text" required><?php echo $question['question_text']; ?></textarea><br>

        <label>Option 1:</label>
        <input type="text" name="option_1" value="<?php echo $question['option_1']; ?>" required><br>

        <label>Option 2:</label>
        <input type="text" name="option_2" value="<?php echo $question['option_2']; ?>" required><br>

        <label>Option 3:</label>
        <input type="text" name="option_3" value="<?php echo $question['option_3']; ?>" required><br>

        <label>Option 4:</label>
        <input type="text" name="option_4" value="<?php echo $question['option_4']; ?>" required><br>

        <label>Correct Option:</label>
        <input type="text" name="correct_option" value="<?php echo $question['correct_option']; ?>" required><br>

        <button type="submit" name="update">Update Question</button>
    </form>
</body>
</html>
