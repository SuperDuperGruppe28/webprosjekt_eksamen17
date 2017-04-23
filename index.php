<?php
require_once __DIR__ . '/database/tools/bruker.php';


registrerBruker("Seb", "seebzei@gmail.com", "123", 1);

if(brukerLoggInn("Seb", "123"))
    echo "<br>logget inn som Seb";
else
    echo "<br>FEIL LOGGINN nissefar";