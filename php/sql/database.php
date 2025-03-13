<?php
function getDbConnection() {
    $dbFile = __DIR__ . '/users.sqlite';
    return new PDO('sqlite:' . $dbFile);
}
