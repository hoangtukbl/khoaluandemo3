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

// Lấy danh sách email
$emails = readEmails();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Client</title>
</head>
<body>
    <h1>Hộp Thư</h1>
    <ul>
        <?php foreach ($emails as $index => $email): ?>
            <li>
                <strong><?= htmlspecialchars($email['subject']) ?></strong>
                <br>
                From: <?= htmlspecialchars($email['from']) ?> | To: <?= htmlspecialchars($email['to']) ?> | Time: <?= htmlspecialchars($email['time']) ?>
                <br>
                <a href="email.php?email=<?= $index ?>">Xem chi tiết</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (isset($_GET['email']) && isset($emails[$_GET['email']])): 
        $email = $emails[$_GET['email']];
    ?>
        <h2>Chi Tiết Email</h2>
        <p><strong>Tiêu Đề:</strong> <?= htmlspecialchars($email['subject']) ?></p>
        <p><strong>From:</strong> <?= htmlspecialchars($email['from']) ?></p>
        <p><strong>To:</strong> <?= htmlspecialchars($email['to']) ?></p>
        <p><strong>Thời Gian:</strong> <?= htmlspecialchars($email['time']) ?></p>
        <p><strong>Nội Dung:</strong></p>
        <pre><?= htmlspecialchars($email['body']) ?></pre>
    <?php endif; ?>
</body>
</html>
