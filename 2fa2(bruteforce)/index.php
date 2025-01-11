<?php
session_start();

$message = '';

function clearEmailsJson() {
    $filePath = 'emails.json';
    // Kiểm tra xem tệp có tồn tại hay không
    if (file_exists($filePath)) {
        // Ghi dữ liệu trống vào tệp để xóa toàn bộ nội dung
        file_put_contents($filePath, json_encode([], JSON_PRETTY_PRINT));
    }
}

// Gọi hàm xóa dữ liệu trong emails.json khi index.php được khởi chạy
clearEmailsJson();

function readUsersFromJson($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }

    $jsonData = file_get_contents($filePath);
    $users = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error decoding JSON: ' . json_last_error_msg());
    }

    return $users;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $filePath = 'users.json';
    $users = readUsersFromJson($filePath);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash_password = hash('sha256', $password);

    if (!isset($users[$username])) {
        $message = 'Invalid username or password';
    } elseif ($users[$username]['password'] !== $hash_password) {
        $message = 'Invalid username or password';
    } else {
        $_SESSION['user'] = $username;

        // Generate 2FA code
        $twofa_code = rand(4000, 4200);
        $_SESSION['2fa_code'] = $twofa_code;

        // Save 2FA code to emails.json
        $email_address = $users[$username]['email'];
        $email_entry = [
            'subject' => 'Your 2FA Code',
            'body' => "Hello $username,\n\nYour 2FA code is: $twofa_code.",
            'from' => 'noreply@example.com',
            'to' => $email_address,
            'time' => date('Y-m-d H:i:s')
        ];
        $emails = json_decode(file_get_contents('emails.json'), true) ?? [];
        $emails[] = $email_entry;
        // if ($username == "admin001"){
            file_put_contents('emails.json', json_encode($emails, JSON_PRETTY_PRINT));
        // }
        // Set token in a cookie
        setcookie('2fa_token', session_id(), time() + 300, "/"); // 5 minutes expiration

        header('Location: 2FA.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f0f0; }
        .login-form { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        .login-form h2 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-group button:hover { background-color: #0056b3; }
        .message { text-align: center; color: red; margin-top: 15px; }
    </style>
</head>
<body>
<div class="login-form">
    <h2>Login</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
        <div class="form-group">
            <a href="resetpassword.php">Forgot password?</a>
        </div>
    </form>
    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
</div>
</body>
</html>
