<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/databaseconfig.php';
require_once __DIR__ . '/database/models.php';

/*test*/
/*
$printTest = Bruker::find(1)->tags;
echo '<pre>';
print_r($printTest);
echo '</pre>';
*/

echo '<pre>';
foreach (TagsBruker::all() as $tags)
{
    print_r($tags->brukere);
    print_r($tags->tags);
}
