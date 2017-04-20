<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/databaseconfig.php';
require_once __DIR__ . '/database/models.php';



echo '<pre>';

// Henter ut brukeren som opprette aktivitet nummer 1
print_r(Aktivitet::find(1)->brukere);
foreach (Aktivitet::all() as $ak)
{
    print_r($ak->brukere);
    //echo ($ak->brukere->Brukernavn);
}



/*

// SUPERTESTER

echo '<pre>';
foreach (Bruker::all() as $brukere)
{
    //print_r($brukere->tags);
    echo ($brukere->tags->Tag);
}

echo '<pre>';

print_r(Bruker::where("Brukernavn", "LIKE", "%a%")->get());

echo '</pre>';

$bru = Bruker::find("seb")->Brukernavn;

$TagsbrukerForste = TagsBruker::all()->where("Bruker", "LIKE", $bru);
//echo dd($TagsbrukerForste);
foreach ($TagsbrukerForste as $tags)
{
   echo $tags->Bruker . " " . $tags->Tag . "<br>";
}

$TagsbrukerAlle = TagsBruker::all();
//echo dd($TagsbrukerForste);
foreach ($TagsbrukerAlle as $tags)
{
   echo $tags->Bruker . " " . $tags->Tag . "<br>";
}


echo '<pre>';
foreach (TagsBruker::all() as $tags)
{
    print_r($tags->brukere);
    print_r($tags->tags);
}
*/