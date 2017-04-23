<?php
require_once __DIR__ . '/database/tools/bruker.php';


if(eksistererBruker("seb"))
    echo "Brukeren seb eksisterer yo";

echo hentEmail("seab");

settAdmin("seb", 1);

if(erAdmin("seb"))
    echo "admin";
else 
    echo "ikke admin";
