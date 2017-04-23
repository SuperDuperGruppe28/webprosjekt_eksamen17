<?php
require_once __DIR__ . '/database/tools/bruker.php';
require_once __DIR__ . '/database/tools/tag.php';
require_once __DIR__ . '/database/tools/aktivitet.php';
require_once __DIR__ . '/database/tools/kommentar.php';

registrerTag("Bade");
registrerBrukerTag("Seb", "Bade", 3);