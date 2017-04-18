<?php
use Illuminate\Database\Capsule\Manager as DB;

$datbas = new DB();
$datbas->addConnection(
    [
        'driver' => 'mysql',
        'port' => 3306,
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'database' => 'aktivitethjemmet',
        'collation' => 'utf8_general_ci'
        
    ]);

$datbas->bootEloquent();