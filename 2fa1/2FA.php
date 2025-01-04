<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['2fa_code'])) {
    header('Location: index.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['2fa_code'];

    if ($entered_code == $_SESSION['2fa_code']) {
        unset($_SESSION['2fa_code']); // Xóa mã 2FA sau khi sử dụng
        header('Location: profile.php?token=' . session_id());
        exit();
    } else {
        $message = 'Invalid 2FA code. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f0f0; }
        .form-container { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        .form-container h2 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-group button:hover { background-color: #0056b3; }
        .message { text-align: center; color: red; margin-top: 15px; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>2FA Verification</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="2fa_code">Enter 2FA Code</label>
            <input type="text" id="2fa_code" name="2fa_code" required>
        </div>
        <div class="form-group">
            <button type="submit">Verify</button>
        </div>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
