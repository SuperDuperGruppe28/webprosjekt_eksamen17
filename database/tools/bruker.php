<?php
//    ____             _             
//   | __ ) _ __ _   _| | _____ _ __ 
//   |  _ \| '__| | | | |/ / _ \ '__|
//   | |_) | |  | |_| |   <  __/ |   
//   |____/|_|   \__,_|_|\_\___|_|   
//    

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';

// Registrerer en ny bruker
function registrerBruker($brukernavn, $email, $passord, $admin)
{
    if(!eksistererBruker($brukernavn))
    {
        $bruker = new Bruker();
        $bruker->Brukernavn = $brukernavn;
        $bruker->Email = $email;
        $bruker->Passord = generatePasswordHash($passord);
        $bruker->Admin = $admin; 
        $bruker->Registrert = date('Y-m-d H:i:s');
        $bruker->Veifiserthash = genererVerifikasjonHash($email);

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

// Returnerer brukerens verifikasjonshash
function hentVerifikasjonsHash($bruker)
{
    if(eksistererBruker($bruker))
    {
        return Bruker::find($bruker)->Veifiserthash;
    }
    return null;
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
function genererVerifikasjonHash($email)
{
    return hash('sha256', $email . time());
}

// Genererer hash av passordet gitt
function generatePasswordHash($pass)
{
    return password_hash($pass, PASSWORD_BCRYPT);
}

// Returnerer true om brukernavn og passord stemmer
function brukerLoggInn($bruker, $pass)
{
    if(eksistererBruker($bruker))
    {
        $passHash = Bruker::find($bruker)->Passord;
        if(password_verify($pass, $passHash))
            return true;
    }
    return false;
}
