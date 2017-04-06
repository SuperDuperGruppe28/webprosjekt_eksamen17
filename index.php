<?php
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as mod;

$datbas = new DB();
$datbas->addConnection(
    [
        'driver' => 'mysql',
        'port' => 80,
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'database' => 'yama',
        'collation' => 'latin1_swedish_ci'
        
    ]);

$datbas->bootEloquent();

class TestModel extends mod
{
    protected $dates = ["starts_at"];
    public $timestamps = false;
}

$printTest = TestModel::all();
print_r($printTest);