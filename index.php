<!DOCTYPE html>
<html>

<body>

  <?php

  date_default_timezone_set('Asia/Tehran');

  $target_dir = "images/";
  $fileName = "IMG_" . date("Ymd_His") . ".jpg";
  $captureTime = date("Y-m-d H:i:s");
  $target_file = $target_dir . $fileName;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["myImage"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["myImage"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
    echo "Sorry, only JPEG files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["myImage"]["tmp_name"], $target_file)) {

      // write image attributes
      echo "<p>File name: " . htmlspecialchars($fileName) . "</p>";
      echo "<p>Captured at: " . htmlspecialchars($captureTime) . "</p>";
      // display the image
      echo "<p><img src='images/" . htmlspecialchars($fileName) . "' /></p>";
    } else {
      // echo "<p>Sorry, there was an error uploading your file.</p>";

      // find the newest image in the 'images' folder
      $files = scandir('images', SCANDIR_SORT_DESCENDING);
      $newest_file = $files[0];

      // write image attributes
      echo "<p>File name: " . htmlspecialchars($newest_file) . "</p>";
      // display the image
      echo "<p><img src='images/" . htmlspecialchars($newest_file) . "' /></p>";
    }
  }

  ?>

</body>

</html>
