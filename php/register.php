<?php
require_once 'sql/database.php';

$message = '';

// POST送信時（フォーム送信時）の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $db = getDbConnection();

        // ユーザー名の重複チェック
        $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $message = 'このユーザー名は既に使用されています。';
        } else {
            // パスワードハッシュ化＆登録
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            if ($stmt->execute([$username, $hashedPassword])) {
                header("Location: login.php");
                exit;         
            } else {
                $message = 'アカウント作成に失敗しました。';
            }
        }
    } else {
        $message = 'ユーザー名とパスワードを入力してください。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
<head>
    <meta charset="UTF-8">
    <title>notthei</title>
</head>
<body>
<div class="login-wrap">
<h2>Cre@te</h2>
<?php if ($message): ?>
    <p style="color:<?php echo (strpos($message, '成功') !== false) ? 'green' : 'red'; ?>">
        <?php echo $message; ?>
    </p>
<?php endif; ?>
<div class="form">
<form method="POST">
    <input type="text" placeholder="Username:" name="username" required><br>
    <input type="password" placeholder="Password:" name="password" required><br>
    <button type="submit">register</button>
</form>
</div>
<p><a href="login.php">login page here</a></p>
</div>
</body>
</html>
