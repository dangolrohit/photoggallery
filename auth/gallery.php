<?php
include('../auth/auth.php'); // Assuming you have an authentication system
include '../database/connect.php'; // Database connection

// Fetching images from the database
$query = "SELECT ID, file FROM images";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="../style.css"> <!-- Link to your CSS -->
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
    <?php include '../component/navbar.php'; ?> <!-- Navbar -->

    <div class="gallery">
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $file_path = '../images/' . $row['file']; 
                echo '<div class="gallery-item" data-id="' . $row['ID'] . '">';
                echo '<img src="' . $file_path . '" alt="Image" onclick="openModal(\'' . $file_path . '\', ' . $row['ID'] . ')">';
                echo '</div>';
            }
        } else {
            echo "<p>No images found in the gallery.</p>";
        }
        ?>
    </div>

    <!-- Modal for displaying the large image -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <div class="intBtn">
                <span class="close" onclick="closeModal()">&times;</span>
                <span class="delete" onclick="deleteImage()">Delete</span>
            </div>
            <img id="modalImage" src="" alt="Large Image">
        </div>
    </div>

    <?php include '../component/footer.php'; ?> <!-- Footer -->

    <script>
        // Open modal to show the large image
        function openModal(imageSrc, imageId) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = "flex";
            document.getElementById('imageModal').dataset.imageId = imageId;
        }

        // Close the modal
        function closeModal() {
            document.getElementById('imageModal').style.display = "none";
        }

        // Delete the image
        function deleteImage() {
            const imageId = document.getElementById('imageModal').dataset.imageId;

            if (confirm('Are you sure you want to delete this image?')) {
                // Send a request to delete the image from the database
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'process/delete_image.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('Image deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete image');
                    }
                };
                xhr.send('id=' + imageId);
            }
        }
    </script>
</body>
</html>

<?php
// Closing the database connection
mysqli_close($conn);
