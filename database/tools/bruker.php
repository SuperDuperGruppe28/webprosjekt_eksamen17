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

// Returnerer emailen til gitt bruker
function hentEmail($bruker)
{
    if(eksistererBruker($bruker))
       return Bruker::find($bruker)->Email;
    return null;
}

// Returnerer om gitt bruker er administrator eller ikke
function erAdmin($bruker)
{
    if(eksistererBruker($bruker))
    {
        return Bruker::find($bruker)->Admin > 0 ? true : false;
    }
    return false;
}

// Setter gitte bruker til admin, 0 = ikke admin > 1 = admin
function settAdmin($bruker, $admin)
{
    if(eksistererBruker($bruker))
    {
        $bru = Bruker::find($bruker);
        $bru->Admin = $admin;
        $bru->save();
        
        return true;
    }
    return false;
}

// Returnerer om gitt bruker er verifisert eller ikke
function erVerifisert($bruker)
{
    if(eksistererBruker($bruker))
    {
        return Bruker::find($bruker)->Verifisert > 0 ? true : false;
    }
    return false;
}

// Setter gitte bruker verifisert 0 = ikke verifisert > 1 = verifisert
function settVerifisert($bruker, $veri)
{
    if(eksistererBruker($bruker))
    {
        $bru = Bruker::find($bruker);
        $bru->Verifisert = $veri;
        $bru->save();
        
        return true;
    }
    return false;
}

// Genere mailverificationhash

// Sette mail verified

