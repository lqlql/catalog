<?php

use Libs\DI;

ini_set('display_errors', 'Off');
error_reporting(-1);
define('LOGDIR_PATH', realpath(APP_PATH . '/../logs'));

require APP_PATH . '/../vendor/autoload.php';
require APP_PATH . '/startup/services.php';

$config = DI::service('config');
if ('development' === $config['application']['env']) {
    ini_set('display_errors', 'On');
}
