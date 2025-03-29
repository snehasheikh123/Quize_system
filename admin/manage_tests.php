<?php
session_start();
include('../includes/db.php');

// Admin ko check karo
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Test ko delete karne ka code
if (isset($_GET['delete_test'])) {
    $test_id = $_GET['delete_test'];
    $conn->query("DELETE FROM personality_tests WHERE test_id = $test_id");
    header('Location: manage_tests.php');
}

// Tests ko fetch karo
$query = "SELECT * FROM personality_tests";
$result = $conn->query($query);
?>

<h2>Manage Tests</h2>
<a href="./admin/add_test.php">➕ Create New Test</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Test Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php while ($test = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $test['test_id']; ?></td>
            <td><?php echo $test['test_name']; ?></td>
            <td><?php echo $test['description']; ?></td>
            <td>
            <a href="edit_question.php?question_id=<?php echo $question['question_id']; ?>">✏️ Edit</a>
            <a href="manage_questions.php?test_id=<?php echo $test['test_id']; ?>">📝 Manage Questions</a> | 
                <a href="manage_tests.php?delete_test=<?php echo $test['test_id']; ?>" onclick="return confirm('Are you sure you want to delete this test?')">❌ Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
