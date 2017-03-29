<?php
require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('G28');
$log->pushHandler(new StreamHandler('logs/test.banan', Logger::WARNING));
// add records to the log
$log->warning('SuperTest');
$log->error('Veldig farlig');

echo 'Skapte log for å teste Composer med laravel';