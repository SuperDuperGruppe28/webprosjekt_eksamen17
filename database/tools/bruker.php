<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';


function registrerBruker($brukernavn, $email, $passord, $admin)
{
    if(!eksistererBruker($brukernavn))
    {
        $bruker = new Bruker();
        $bruker->Brukernavn = $brukernavn;
        $bruker->Email = $email;
        $bruker->Passord = $passord;
        $bruker->admin = $admin;
        
        $bruker->save();
        return true;
    }
    
    return false;
}

// Returnerer om brukeren eksisterer i databasen
function eksistererBruker($bruker)
{
    return (Bruker::find($bruker)) !== null ? true : false;
}

registrerBruker("Mamammllama", "ss", "saa", 1);