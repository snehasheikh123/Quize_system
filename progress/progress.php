<?php
// ✅ Connection include karo
include('../includes/db.php');

$user_id = $_POST['user_id'] ?? null;
$career_id = $_POST['career_id'] ?? null;
$test_id = $_POST['test_id'] ?? null;
$progress_status = $_POST['progress_status'] ?? null;

if ($career_id === null) {
    die('❌ Error: Career ID is missing.');
}

// ✅ Career ID ko validate karo
$query = "SELECT * FROM career_paths WHERE career_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $career_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('❌ Error: Career ID does not exist in career_paths table.');
}

// ✅ Data ko insert karo agar career mil gaya to
$stmt = $conn->prepare("INSERT INTO progress_tracking (user_id, career_id, test_id, progress_status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $user_id, $career_id, $test_id, $progress_status);

if ($stmt->execute()) {
    echo "✅ Progress recorded successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
