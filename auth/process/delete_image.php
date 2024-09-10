<?php
include('../auth.php'); 
include '../../database/connect.php'; 

if (isset($_POST['id'])) {
    $imageId = intval($_POST['id']);

    $query = "SELECT file FROM images WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $imageId);
    $stmt->execute();
    $stmt->bind_result($file);
    $stmt->fetch();
    $stmt->close();

    if ($file) {
        $file_path = '../images/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $deleteQuery = "DELETE FROM images WHERE ID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('i', $imageId);
        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Failed to delete from database";
        }
        $stmt->close();
    } else {
        echo "Image not found";
    }
}
mysqli_close($conn);
