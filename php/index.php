<?php
session_start();
if (isset($_SESSION['user'])) {
   // echo "ようこそ、" . htmlspecialchars($_SESSION['user']['username']) . "さん";
    ?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>welcome</title>
        
    </head>
    <body>
    <h1> aaaaa </h1>
    </body>
    </html>
    <?php
} else {
    header("Location: login.php");
}

?>

