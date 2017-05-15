<?php
//   ___  ____                                                   _                  
//  |_  ||_  _|                                                 / |_                
//    | |_/ /    .--.   _ .--..--.   _ .--..--.  .---.  _ .--. `| |-',--.   _ .--.  
//    |  __'.  / .'`\ \[ `.-. .-. | [ `.-. .-. |/ /__\\[ `.-. | | | `'_\ : [ `/'`\] 
//   _| |  \ \_| \__. | | | | | | |  | | | | | || \__., | | | | | |,// | |, | |     
//  |____||____|'.__.' [___||__||__][___||__||__]'.__.'[___||__]\__/\'-;__/[___]    
//                                                                                                                          
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';
require_once "bruker.php";
require_once "aktivitet.php";

// Skaper et kommentarfelt for en aktivitet
function skapKommentarfelt($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $kommentarfelt = new Kommentarfelt();
        // if kommentarfelt eksisterer
        $kommentarfelt->Aktivitet = $aktivitet;
        $kommentarfelt->save();
        
        return true;
    }
    return false;
}

// Poster en kommentar
function postKommentar($bruker, $aktivitet, $tekst)
{
    if(eksistererBruker($bruker) && eksistererAktivitet($aktivitet))
    {
        $kommentarfeltId = hentAktivitetKommentarfelt($aktivitet);
        if($kommentarfeltId > 0)
        {
            $kommentar = new Kommentar();
            $kommentar->Bruker = $bruker;
            $kommentar->Kommentarfelt = $kommentarfeltId;
            $kommentar->Tekst = $tekst;
            $kommentar->Dato = date('Y-m-d H:i:s');
            $kommentar->save();
        
            return true;
        }
    }
    
    return false;
}

// Sjekker om kommentar med id eksisterer
function eksistererKommentar($kommentar)
{
    return (Kommentar::find($kommentar)) !== null ? true : false;
}

// Endrer teksten på en kommentar ved gitt id
function redigerKommentar($kommentar, $tekst)
{
    if(eksistererKommentar($kommentar))
    {
        $kom = Kommentar::find($kommentar)->first();
        $kom->Tekst = $tekst;
        $kom->save();
        
        return true;
    }
    
    return false;
}

// Sletter kommentar med gitt id
function slettKommentar($kommentar)
{
    if(eksistererKommentar($kommentar))
    {
        $kom = Kommentar::find($kommentar)->first();
        $kom->delete();
        
        return true;
    }
    
    return false;
}

// Sletter alle kommentarer i aktivitet
function slettKommentarer($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $kommentarfeltId = hentAktivitetKommentarfelt($aktivitet);
        
        $kommentarer = Kommentar::where("Kommentarfelt", "=", $kommentarfeltId);
        $kommentarer->delete();
        
        return true;
    }
    
    return false;
}

// Returnerer brukernavnet til eieren av kommentaren
function finnKommentarEier($kommentar)
{
     if(eksistererKommentar($kommentar))
    {
        $kom = Kommentar::find($kommentar)->first();
        return  $kom->Bruker;
    }
    
    return false;
}

// Returnerer kommentarene i en aktivitet
function hentKommentarer($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $kommentarfeltId = hentAktivitetKommentarfelt($aktivitet);
        
        $kommentarer = Kommentar::where("Kommentarfelt", "=", $kommentarfeltId)->orderBy('Dato', 'desc')->get();
        
        return $kommentarer;
    }
    return false;
}

function tryggPrint($inn)
{
    return htmlspecialchars($inn, ENT_QUOTES, 'UTF-8');
}