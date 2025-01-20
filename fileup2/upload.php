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

    $fileType = $_FILES["fileToUpload"]["type"];
    $allowedTypes = ['image/jpeg', 'image/png'];

    // Kiểm tra định dạng tệp
    if (in_array($fileType, $allowedTypes)) {
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . "ava." . $imageFileType;

        // Di chuyển tệp tải lên tới thư mục đích
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $message = "Tệp đã được tải lên thành công!";
        } else {
            $message = "Đã xảy ra lỗi khi tải lên tệp.";
        }
    } else {
        // $message = "Vui lòng tải lên tệp có định dạng .jpg hoặc .png.";
        $message = $fileType;

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
        $relative_path = $target_dir . basename($existing_file[0]);
        if (file_exists($relative_path)) {
            if (is_readable($relative_path)) {
                // echo $relative_path;
                echo '<img src="' . $relative_path . '" alt="Uploaded Image">';
            } else {
                echo "<p>Không thể đọc tệp hình ảnh.</p>";
            }
        } else {
            echo "<p>Không tìm thấy tệp hình ảnh.</p>";
        }
    }
    ?>
</body>
</html>