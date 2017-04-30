<?php
require_once __DIR__ . '/pages/main.php';
require_once __DIR__ . '/database/tools/bruker.php';

$brukernavn = loggetInnBruker();
if($brukernavn)
   echo "Logget inn som: " . $brukernavn;
else
   echo "Ikke logget inn";