<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM personality_tests";
$result = $conn->query($query);
?>

<h2>Available Tests</h2>
<table border="1">
    <tr>
        <th>Test Title</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <?php while ($test = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $test['test_name']; ?></td>
            <td><?php echo $test['description']; ?></td>
            <td>
                <a href="../tests/start_test.php?test_id=<?php echo $test['test_id']; ?>">Start Test</a>
            </td>
        </tr>
    <?php } ?>
</table>
