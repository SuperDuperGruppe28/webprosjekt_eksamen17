<?php
require_once __DIR__ . '/database/tools/bruker.php';

$brukernavn = loggetInnBruker();
if($brukernavn)
{
    echo "Logget inn som: " . $brukernavn;
   echo "<img src=".hentBrukerBilde()." width='40px' height='40px'></img>";
}
else
   echo "Ikke logget inn";

require_once __DIR__ . '/pages/main.php';