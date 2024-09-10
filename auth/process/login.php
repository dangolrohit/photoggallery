<?php
session_start();
include '../../database/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT email, password FROM userdata WHERE email = ?");
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $db_email = $row['email'];
    $db_password = $row['password'];

    if ($password === $db_password) {
        $_SESSION['username'] = $username;
        header("Location: ../auth/dashboard.php");
        exit();
    } else {
        echo "<script>
                alert('Invalid password for username:');
                window.location.href = '../../index.php';
              </script>";
        exit(); 
    }
} else {
    echo "<script>
            alert('Invalid Username ');
            window.location.href = '../../index.php';
          </script>";
    exit(); 
}
$stmt->close();
$conn->close();
?>
