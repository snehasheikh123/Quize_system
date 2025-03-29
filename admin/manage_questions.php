<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_GET['test_id'])) {
    echo "Test ID is missing!";
    exit();
}

$test_id = $_GET['test_id'];

// Question delete karne ka code
if (isset($_GET['delete_question'])) {
    $question_id = $_GET['delete_question'];
    $conn->query("DELETE FROM questions WHERE question_id = $question_id");
    echo "<script>alert('Question deleted successfully!'); window.location='manage_questions.php?test_id=$test_id';</script>";
}

// Questions ko fetch karo
$query = "SELECT * FROM questions WHERE test_id = $test_id";
$result = $conn->query($query);
?>

<h2>Manage Questions</h2>
<a href="./add_questions.php?test_id=<?php echo $test_id; ?>">➕ Add New Question</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Question Text</th>
        <th>Option 1</th>
        <th>Option 2</th>
        <th>Option 3</th>
        <th>Option 4</th>
        <th>Correct Option</th>
        <th>Actions</th>
    </tr>
    <?php while ($question = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $question['question_id']; ?></td>
            <td><?php echo $question['question_text']; ?></td>
            <td><?php echo $question['option_1']; ?></td>
            <td><?php echo $question['option_2']; ?></td>
            <td><?php echo $question['option_3']; ?></td>
            <td><?php echo $question['option_4']; ?></td>
            <td><?php echo $question['correct_option']; ?></td>
            <td>
                <a href="edit_question.php?question_id=<?php echo $question['question_id']; ?>">✏️ Edit</a> | 
                <a href="manage_questions.php?test_id=<?php echo $test_id; ?>&delete_question=<?php echo $question['question_id']; ?>" onclick="return confirm('Are you sure you want to delete this question?')">❌ Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
