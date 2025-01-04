<?php
// Nhận token từ GET
$token = $_GET['token'] ?? null;

if (!$token) {
    die("no token available.");
}

// Tra cứu token để lấy email
$tokens = json_decode(file_get_contents('tokens.json'), true);
$email = array_search($token, $tokens);

if (!$email) {
    die("Invalid token.");
}

// Tra cứu email để lấy username
$users = json_decode(file_get_contents('users.json'), true);
$username = null;

foreach ($users as $user => $data) {
    if ($data['email'] === $email) {
        $username = $user;
        break;
    }
}

if (!$username) {
    die("No user found.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="post" action="">
        <!-- Chuyển tiếp dữ liệu GET vào POST -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];
    $email = $_POST['email'];
    $username = $_POST['username'];    
    
    // Đọc token và user data từ file JSON
    $tokens = json_decode(file_get_contents('tokens.json'), true);
    $users = json_decode(file_get_contents('users.json'), true);

    // Tìm email dựa vào token
    $email = array_search($token, $tokens);

    if ($email) {
        // Tìm username dựa vào email
        // $username = null;
        // foreach ($users as $user => $data) {
        //     if ($data['email'] === $email) {
        //         $username = $user;
        //         break;
        //     }
        // }

        if ($username) {
            // Cập nhật mật khẩu mới
            $users[$username]['password']= hash('sha256', $newPassword);
            file_put_contents('users.json', json_encode($users));

            // Xóa token sau khi sử dụng
            unset($tokens[$email]);
            file_put_contents('tokens.json', json_encode($tokens));

            // echo "Mật khẩu của bạn đã được thay đổi thành công!";
            echo $newPassword;
        } else {
            echo "Không tìm thấy user nào khớp với email.";
        }
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
?>
<!-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="post" action="">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">Nhập mật khẩu mới:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html> -->
<?php
} else {
    echo "Token không hợp lệ.";
}
?>
