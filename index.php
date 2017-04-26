<?php
require_once __DIR__ . '/database/tools/bruker.php';
require_once __DIR__ . '/database/tools/tag.php';
require_once __DIR__ . '/database/tools/aktivitet.php';
require_once __DIR__ . '/database/tools/kommentar.php';


registrerBruker("Ape", "seebzei@gmail.com", "123", 1);

//skapAktivitet("Seb", "Badiing", "Bade i vann", "Alltid åpent", 0, 1, "Bildeurl", 0, 0);
//postKommentar("Seb", 3, "kommentar");

//redigerKommentar(1, "Dette er en endring");
//slettAktivitet(3);

deltaAktivitet("Seb", 4, 2);
echo hentDeltagelse("Seb", 4);

slettStemmer(4);