<?php
session_start();
require_once 'sql/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = getDbConnection();

    $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    } else {
        $error = "ユーザー名またはパスワードが違います";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="style.css">


<header>
<meta charset="UTF-8">
<title>notthei</title>
<script src="script.js"></script>
</header>

<body>

<div class="login-wrap">
<h2>L0g1n</h2>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<div class="form">
<form method="POST">
    <input type="text" placeholder="Username:" name="username" required><br>
    <input type="password" placeholder="Password:"  name="password" required>

    <button type="submit" >login</button>
</form>
</div>
<p><a href="register.php">create an account</a></p>
</div>
</body>
</html>
