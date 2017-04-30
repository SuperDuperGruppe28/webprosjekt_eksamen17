<?php
use Illuminate\Database\Capsule\Manager as DB;

// Setter tidssone til Oslo
define("TIDSSONE", "Europe/Oslo");
date_default_timezone_set(TIDSSONE);

// Db config
$datbas = new DB();
$datbas->addConnection(
    [
        'driver' => 'mysql',
        'port' => 3306,
        'host' => 'tek.westerdals.no',
        'username' => 'berseb16_g28',
        'password' => 'MmU{@N}@(#2c',
        'database' => 'berseb16_aktivitet',
        'collation' => 'utf8_general_ci'
        
    ]);

$datbas->bootEloquent();