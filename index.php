<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/databaseconfig.php';
require_once __DIR__ . '/database/models.php';


$printTest = TestModel::all();
echo '<pre>';
print_r($printTest);