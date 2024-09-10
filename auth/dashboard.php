<?php
include('../auth/auth.php');
include '../database/connect.php';
if (isset($_POST['submit'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = __DIR__ . '/../images/' . $file_name;

        // Ensure the images directory exists
        if (!file_exists(__DIR__ . '/../images')) {
            mkdir(__DIR__ . '/../images', 0777, true);
        }

        // Secure the SQL query with prepared statements
        $stmt = $conn->prepare("INSERT INTO images (file) VALUES (?)");
        $stmt->bind_param("s", $file_name);

        if (move_uploaded_file($tempname, $folder) && $stmt->execute()) {
            echo "<script>
            alert('Upload Successful');
          </script>";
        } else {
            echo "<script>
                alert('Failed to upload image.');
              </script>";
        }

        $stmt->close();
    } else {
        echo "No file was uploaded or there was an error with the upload.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="upload.css">

</head>
<body>
    <?php include '../component/navbar.php'; ?>

    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <form method="post" enctype="multipart/form-data">

    <div class="file-upload">
        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )" name="image">Add Image</button>
        
        <div class="image-upload-wrap">
    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="image"/>
    <div class="drag-text">
      <h3>Drag and drop a file or select add Image</h3>
    </div>
  </div>
  <div class="file-upload-content">
    <img class="file-upload-image" src="#" alt="your image" />
    <div class="image-title-wrap">
      <button type="button" onclick="removeUpload()" class="remove-image">Remove</button>
      <button type="submit" name="submit" class="submit-image">Submit</button>
    </div>
  </div>
</div>
    </form>
    <?php include '../component/footer.php'; ?>
    <?php include './chat/chat.php'; ?>
</body>
<script>
    function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});

</script>
</html>
