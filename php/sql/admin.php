<?php
session_start();
require_once 'database.php';

// 管理者かどうかのチェック
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    // 管理者でない場合、ログインページへリダイレクト
    header('Location: login.php');
    exit;
}

$message = '';

// ユーザー削除処理
if (isset($_GET['delete_id'])) {
    $userId = (int)$_GET['delete_id'];

    $db = getDbConnection();
    // ユーザーを削除
    $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
    if ($stmt->execute([$userId])) {
        $message = 'ユーザーが削除されました。';
    } else {
        $message = 'ユーザー削除に失敗しました。';
    }
}

// ユーザー一覧取得
$db = getDbConnection();
$stmt = $db->query('SELECT id, username FROM users');
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ページ</title>
</head>
<body>
<h2>ユーザー管理</h2>

<?php if ($message): ?>
    <p style="color:<?php echo (strpos($message, '失敗') !== false) ? 'red' : 'green'; ?>">
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<h3>ユーザー一覧</h3>
<table border="1">
    <tr>
        <th>ユーザー名</th>
        <th>操作</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><a href="admin.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('本当に削除しますか？');">削除</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="logout.php">ログアウト</a></p>
</body>
</html>
