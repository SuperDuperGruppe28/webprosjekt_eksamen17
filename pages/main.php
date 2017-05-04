<?php
require_once __DIR__ . '/../database/tools/bruker.php';

echo "<h3>Hello main body!</h3>";
 $brukernavn = loggetInnBruker();
 if($brukernavn)
 {
    echo "Logget inn som: " . $brukernavn;
    echo "<img src=".hentBrukerBilde()." width='40px' height='40px'></img>";
 }
 else
    echo "Ikke logget inn";
?>

<h1>Snart blir denne siden veldig sexy</h1>