<?php
require_once __DIR__ . '/pages/main.php';


require_once __DIR__ . '/database/tools/bruker.php';
echo hentEmail('Seb');
registrerBruker("Sebto", "mail", "123", 1);