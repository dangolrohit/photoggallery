
<?php
include '../../database/connect.php';

$stmt = $conn->prepare("INSERT INTO messages (sender_email, receiver_email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $sender_email, $receiver_email, $message);

// Set parameters and execute
$sender_email = $_POST['sender_email'];
$receiver_email = $_POST['receiver_email'];
$message = $_POST['message'];

if ($stmt->execute()) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>