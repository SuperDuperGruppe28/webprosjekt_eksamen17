<?php
//    ____             _             
//   | __ ) _ __ _   _| | _____ _ __ 
//   |  _ \| '__| | | | |/ / _ \ '__|
//   | |_) | |  | |_| |   <  __/ |   
//   |____/|_|   \__,_|_|\_\___|_|   
//    
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';

// Starter session
if (session_status() == PHP_SESSION_NONE) 
    session_start();

// Returnerer brukernavnet til logget inn bruker
function loggetInnBruker()
{
    if(erBrukerLoggetInn())
    {
        return $_SESSION["user"];
    }
    return false;
}

function hentBruker($bruker)
{
    if(eksistererBruker($bruker))
    {
        return Bruker::find($bruker);
    }
    return false;
}

// Returnerer om en bruker er logget inn
function erBrukerLoggetInn()
{
    if(isset($_SESSION["user"]))
        return true;
    return false;
}

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

// Returner profilbildelink
function hentBrukerBildeEx($bruker)
{
    if(eksistererBruker($bruker))
    {
        $email = hentEmail($bruker);
        $default = "https://cdn.pixabay.com/photo/2016/04/17/16/10/cat-1334970_960_720.jpg";
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode( $default ) . "&s=" . $size;
        if($grav_url == '') $grav_url = $default;
        return $grav_url;
    }
    return "";
}

// Returner profilbildelink
function hentBrukerBilde()
{
    if(erBrukerLoggetInn())
    {
        $email = hentEmail(loggetInnBruker());
        $default = "https://cdn.pixabay.com/photo/2016/04/17/16/10/cat-1334970_960_720.jpg";
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode( $default ) . "&s=" . $size;
        if($grav_url == '') $grav_url = $default;
        return $grav_url;
    }
    return "";
}

function sendVerifiseringsEmail($bruker)
{
    if(eksistererBruker($bruker))
    {
        $email = hentEmail($bruker);
        $veri = hentVerifikasjonsHash($bruker);
        $url = "http://localhost/php/email.php?user=".$bruker."&ver=" . $veri;
        $message = "Trykk på lenken for å verifisere din emailadresse: " . $url . " \n Ha en fin dag!";
        mail($email, "Verifiser din emailadresse", $message);
        return true;
    }
    return false;
}

// Returner resultat fra søk
function sokBruker($sok)
{
    return Bruker::where(function ($query) use ($sok) 
    {
        $query->where('Brukernavn', 'LIKE', "%".$sok."%")
          ->orWhere('Email', 'LIKE', "%".$sok."%");
    })->get();
}

function printBrukerBoksFraArray($bruker)
{
    $klasse = "";
    if(erAdmin($bruker))
        $klasse = "tagLink";
    echo "<a class='".$klasse."' href='?side=bruker&id=".$bruker."'><img height='40px' width='40px' src='".hentBrukerBildeEx($bruker)."'/>".$bruker."</a><br>";
}