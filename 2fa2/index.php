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
// Hàm đọc dữ liệu từ tệp JSON
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
        // Lưu username vào cookie
        setcookie("user", $username, time() + 3600, "/");
        header('Location: 2FA.php?2facheck=true');
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
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-form h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>