<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}

$target_dir = "uploads/user01/";
$existing_file = glob($target_dir . "ava.*");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xóa tệp cũ nếu có
    if (!empty($existing_file)) {
        unlink($existing_file[0]);
    }

    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . "ava." . $imageFileType;

    // Di chuyển tệp tải lên tới thư mục đích
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "Tệp đã được tải lên thành công!";
    } else {
        $message = "Đã xảy ra lỗi khi tải lên tệp.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

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
    <?php
    if (isset($message)) echo "<p>$message</p>";
    if (!empty($existing_file)) {
        echo '<img src="' . $existing_file[0] . '" alt="Uploaded Image">';
    }
    ?>
</body>
</html>