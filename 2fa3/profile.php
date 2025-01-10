<?php
session_start();

// if (!isset($_SESSION['user']) || !isset($_COOKIE['2fa_token'])) {
//     header('Location: index.php');
//     exit();
// }

$username = $_SESSION['user'];
$users = json_decode(file_get_contents('users.json'), true);
$email = $users[$username]['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    setcookie('2fa_token', '', time() - 3600, "/"); // Clear the token cookie
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f0f0; }
        .profile-container { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        .profile-container h2 { text-align: center; }
        .info { margin-bottom: 15px; }
        .info label { font-weight: bold; }
        .logout-btn { width: 100%; padding: 10px; background-color: #d9534f; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .logout-btn:hover { background-color: #c9302c; }
    </style>
</head>
<body>
<div class="profile-container">
    <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
    <div class="info">
        <label>Email:</label>
        <p><?= htmlspecialchars($email) ?></p>
    </div>
    <form method="POST" action="">
        <button class="logout-btn" type="submit" name="logout">Logout</button>
    </form>
</div>
</body>
</html>
