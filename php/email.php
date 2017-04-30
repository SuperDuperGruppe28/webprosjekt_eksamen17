<?php
require_once __DIR__ . '/../database/tools/bruker.php';

// Om action er valgt
if(isset($_GET["ver"]) && isset($_GET["user"]))
{
    $user = $_GET["user"];
    $verification = $_GET["ver"];
    
    if(!erVerifisert($user))
    {
        if(hentVerifikasjonsHash($user) === $verification)
        {
            settVerifisert($user, 1);
            echo "<h1>" . $user . " har blitt verifisert!</h1>";
        }else
        {
            echo "<h1>Verifikasjonskoden stemmer ikke!</h1>";
        }
    }else
    {
        echo "<h1>" . $user . " er allerede verifisert!</h1>";
    }
  
}else
{
    echo "<h1>Mangler data!</h1>";
}