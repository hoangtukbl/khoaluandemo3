<?php
// Đường dẫn file lưu trữ email
$emailFile = 'emails.json';

// Đọc danh sách email
function readEmails() {
    global $emailFile;
    if (!file_exists($emailFile)) {
        return [];
    }
    $emails = json_decode(file_get_contents($emailFile), true);
    return is_array($emails) ? $emails : [];
}

// Lưu email mới
function saveEmail($subject, $body, $from, $to) {
    global $emailFile;
    $emails = readEmails();
    $emails[] = [
        'subject' => $subject,
        'body' => $body,
        'from' => $from,
        'to' => $to,
        'time' => date('Y-m-d H:i:s')
    ];
    file_put_contents($emailFile, json_encode($emails));
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $users = json_decode(file_get_contents('users.json'), true);

    // echo ($users);
    // Kiểm tra email tồn tại
    $userExists = false;
    $usernameToGet = null;

    // foreach ($users as $username => $data) {
    //     if ($data['email'] === $email) {
    //         $userExists = true;
    //         $usernameToGet = $username;
    //         break;
    //     }
    // }
    // echo $users;
    foreach ($users as $user => $data) {
        if ($data['email'] === $email) {
            $usernameToGet = $user;
            break;
        }
    }
    if($usernameToGet != null){
        $userExists = true;
    }

    if ($userExists) {
        // Tạo token và lưu
        $token = bin2hex(random_bytes(16)); // Tạo token ngẫu nhiên
        $tokens = json_decode(file_get_contents('tokens.json'), true);
        $tokens[$email] = $token;
        file_put_contents('tokens.json', json_encode($tokens));
        // header("Location: passconfirm.php?token=$token&email=$email&username=$usernameToGet");

        // Gửi email (giả lập bằng cách hiển thị)
        $resetLink = "http://localhost:8000/passconfirm.php?token=$token";
        // Gửi email qua email client
        saveEmail(
            "Reset Password",
            "Xin chào, \n\nBạn đã yêu cầu đặt lại mật khẩu. Hãy nhấp vào đường link sau để đặt lại mật khẩu:\n\n$resetLink\n\nThời gian gửi: " . date('Y-m-d H:i:s'),
            "noreply@example.com",
            $email
        );
        echo "Check your email (/email.php)";
        // echo $usernameToGet;
    } else {
        echo "Email not exist";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form method="post" action="">
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Send Request</button>
    </form>
</body>
</html>
