<?php
// Định nghĩa giá trị mã hóa sẵn của username và password
// define('ENCODED_USERNAME', 'f51739fd6372274f543ab95b3aebfa03c824f976392bf40bb8cdca23b164fc22'); // Giá trị mã hóa sẵn của username admin001
// define('ENCODED_PASSWORD', '1785cfc3bc6ac7738e8b38cdccd1af12563c2b9070e07af336a1bf8c0f772b6a'); // Giá trị mã hóa sẵn của password  nothing

$message = '';

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
        // Username không tồn tại
        $message = 'Invalid username or password';
    } elseif ($users[$username]['password'] !== $hash_password) {
        // Password sai
        $message = 'Invalid username or password';
    } else {
        // Login thành công
        $message = 'Login successfully';
    }

    // echo $message;
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login <Form></Form></title>
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
