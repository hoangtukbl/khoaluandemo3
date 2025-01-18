<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/wiener/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "File has been uploaded successfully!";
    } else {
        $message = "An error occurred while uploading the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" action="upload.php">
        <input type="file" name="fileToUpload" required><br>
        <button type="submit">Upload</button>
    </form>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</body>
</html>