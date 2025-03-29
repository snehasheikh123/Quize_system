<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $test_id = $_POST['test_id'];

    // ✅ Clear previous answers (if user is retaking the test)
    $query_delete = "DELETE FROM user_answers WHERE user_id = ? AND test_id = ?";
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param("ii", $user_id, $test_id);
    $stmt->execute();
    $stmt->close();

    $score = 0;
    $attempted = 0;

    // ✅ Check if answers exist before processing
    if (isset($_POST['answers']) && is_array($_POST['answers'])) {
        foreach ($_POST['answers'] as $question_id => $answer) {
            if (!empty($answer)) {
                // ✅ Save answer to `user_answers`
                $query_insert = "INSERT INTO user_answers (user_id, test_id, question_id, answer) 
                                VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query_insert);
                $stmt->bind_param("iiis", $user_id, $test_id, $question_id, $answer);
                $stmt->execute();
                $stmt->close();

                $attempted++;

                // ✅ Check if answer is correct
                $query_correct = "SELECT correct_option, marks FROM questions WHERE question_id = ?";
                $stmt = $conn->prepare($query_correct);
                $stmt->bind_param("i", $question_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $correct_option = $row['correct_option'];
                    $marks = $row['marks'];

                    if ($answer === $correct_option) {
                        $score += $marks;
                    }
                }
                $stmt->close();
            }
        }
    }

    // ✅ Career Suggestion Based on Score
    $career_suggestion = 'No suggestion available';

    $query_suggestion = "SELECT cp.career_title 
                         FROM career_suggestions cs
                         JOIN career_paths cp ON cs.career_id = cp.career_id
                         WHERE cs.min_score <= ? AND cs.max_score >= ?";
    $stmt = $conn->prepare($query_suggestion);
    $stmt->bind_param("ii", $score, $score);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $career_suggestion = $row['career_title'];
    }
    $stmt->close();

    // ✅ Save Test Result to `test_results`
    $result_type = ($score >= 50) ? 'Pass' : 'Fail';

    $query_result = "INSERT INTO test_results (user_id, test_id, result_type, score, career_recommendation, completed_at) 
                     VALUES (?, ?, ?, ?, ?, NOW()) 
                     ON DUPLICATE KEY UPDATE 
                     score = VALUES(score), 
                     career_recommendation = VALUES(career_recommendation), 
                     completed_at = NOW()";
    $stmt = $conn->prepare($query_result);
    $stmt->bind_param("iisis", $user_id, $test_id, $result_type, $score, $career_suggestion);
    $stmt->execute();
    $stmt->close();

    // ✅ Redirect to Result Page
    header("Location: view_results.php?test_id=$test_id");
    exit();
} else {
    die("Invalid Request!");
}
?>
