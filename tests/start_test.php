<?php
session_start();
include('../includes/db.php');
include('../includes/sidebar.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}

if (!isset($_GET['test_id'])) {
    echo "Invalid Test ID!";
    exit();
}

$test_id = $_GET['test_id'];
$user_id = $_SESSION['user_id'];

$_SESSION['test_id'] = $test_id;

// ✅ Corrected column name
$query = "SELECT question_id, question_text, option_1, option_2, option_3, option_4 FROM questions WHERE test_id = ? ORDER BY question_id ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Test</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    <h2>Start Test</h2>

    <form action="submit_test.php" method="POST">
        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="question-card">
                <input type="hidden" name="question_id[]" value="<?php echo $row['question_id']; ?>">
                <label class="question-text"><?php echo htmlspecialchars($row['question_text']); ?></label><br>

                <div class="options">
                    <?php if (!empty($row['option_1'])) { ?>
                        <label class="option">
                            <input type="radio" name="answer_<?php echo $row['question_id']; ?>" value="<?php echo htmlspecialchars($row['option_1']); ?>">
                            <?php echo htmlspecialchars($row['option_1']); ?>
                        </label>
                    <?php } ?>
                    <?php if (!empty($row['option_2'])) { ?>
                        <label class="option">
                            <input type="radio" name="answer_<?php echo $row['question_id']; ?>" value="<?php echo htmlspecialchars($row['option_2']); ?>">
                            <?php echo htmlspecialchars($row['option_2']); ?>
                        </label>
                    <?php } ?>
                    <?php if (!empty($row['option_3'])) { ?>
                        <label class="option">
                            <input type="radio" name="answer_<?php echo $row['question_id']; ?>" value="<?php echo htmlspecialchars($row['option_3']); ?>">
                            <?php echo htmlspecialchars($row['option_3']); ?>
                        </label>
                    <?php } ?>
                    <?php if (!empty($row['option_4'])) { ?>
                        <label class="option">
                            <input type="radio" name="answer_<?php echo $row['question_id']; ?>" value="<?php echo htmlspecialchars($row['option_4']); ?>">
                            <?php echo htmlspecialchars($row['option_4']); ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <button type="submit" class="btn-submit">Submit</button>
    </form>
</div>

<?php
$stmt->close();
?>

</body>
</html>
<style>/* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container */
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

/* Heading */
h2 {
    text-align: center;
    color: #333;
}

/* Question Card */
.question-card {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f1f1f1;
    border-left: 5px solid #007bff;
    border-radius: 8px;
}

/* Question Text */
.question-text {
    font-size: 18px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    color: #444;
}

/* Options */
.options {
    display: flex;
    flex-direction: column;
}

.option {
    display: flex;
    align-items: center;
    padding: 8px;
    margin-bottom: 5px;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 5px;
    transition: background-color 0.3s;
    cursor: pointer;
}

.option input[type="radio"] {
    margin-right: 10px;
}

/* Option Hover Effect */
.option:hover {
    background-color: #d6d8db;
}

/* Submit Button */
.btn-submit {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-submit:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        padding: 10px;
    }

    .option {
        font-size: 14px;
    }

    .btn-submit {
        font-size: 14px;
    }
}
</style> 