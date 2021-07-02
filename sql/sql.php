<?php

use Libs\DI;

define('APP_PATH', realpath(__DIR__ . '/../app'));
require APP_PATH . '/startup/init.php';
$files = glob(APP_PATH . '/../sql/migrate/*');
foreach ($files as $file) {
    $sql = file_get_contents($file);
    $pdo = DI::service('mysql')->getConnection('write');
    $sth = $pdo->query($sql);
    $sth->closeCursor();
}