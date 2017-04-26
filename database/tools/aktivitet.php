<?php
//       _    _    _   _       _ _       _   
//      / \  | | _| |_(_)_   _(_) |_ ___| |_ 
//     / _ \ | |/ / __| \ \ / / | __/ _ \ __|
//    / ___ \|   <| |_| |\ V /| | ||  __/ |_ 
//   /_/   \_\_|\_\\__|_| \_/ |_|\__\___|\__|
//                                           

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';
require_once "bruker.php";

// Oppretter en ny aktivitet
function skapAktivitet($bruker, $tittel, $beskrivelse, $apning, $pris, $statisk, $bilde, $lon, $lat)
{
    if(eksistererBruker($bruker))
    {
        $akti = new Aktivitet();
        $akti->Bruker = $bruker;
        $akti->Tittel = $tittel;
        $akti->Beskrivelse = $beskrivelse;
        $akti->Apningstider = $apning;
        $akti->Pris = $pris;
        $akti->Statisk = $statisk;
        $akti->Bilde = $bilde;
        $akti->Lengdegrad = $lon;
        $akti->Breddegrad = $lat;
        $akti->save();
            
        // Oppretter kommentarfelt for aktivitet
        skapKommentarfelt($akti->id);
        return true;
    }
    return false;
}

// Sletter aktivtet og relasjoner
function slettAktivitet($aktivitet)
{
     if(eksistererAktivitet($aktivitet))
    {
        $akt = Aktivitet::find($aktivitet);
        slettKommentarer($aktivitet);
        $akt->kommentarfelt->delete();
        $akt->delete();
         
        return true;
    }
    return false;
}

// Sjekker om aktivtet eksisterer
function eksistererAktivitet($aktivitet)
{
    return (Aktivitet::find($aktivitet)) !== null ? true : false;   
}

// Henter kommentarfeltiden til en gitt aktivitet
function hentAktivitetKommentarfelt($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $kommentarfelt = Aktivitet::find($aktivitet)->kommentarfelt->where("Aktivitet", "=", $aktivitet)->first();
        return $kommentarfelt->id;
    }
    return -1;
}

// Redigere aktivitet

// Oppreter deltakelse i en gitt aktivtet, bruker, aktivitet, Integer
function deltaAktivitet($bruker, $aktivitet, $delta)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        // Om brukeren allerede deltar i aktivtet, ikke lag ny
        if(hentDeltagelse($bruker, $aktivitet) <= 0)
        {
            $deltagelse = new Deltagelse();
            $deltagelse->Bruker = $bruker;
            $deltagelse->Aktivitet = $aktivitet;
            $deltagelse->Deltagelse = $delta; 
            $deltagelse->save();
        
            return true;
        }
    }
    return false;
}

// Endrer deltagelse for gitt bruker og aktivitet
function endreDeltagelse($bruker, $aktivitet, $delta)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        $deltagelse = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $deltagelse = $deltagelse->where("Bruker", "LIKE", $bruker)->first();
        
        if($deltagelse !== null)
        {
            $deltagelse->Deltagelse = $delta; 
            $deltagelse->save();
        
            return true;
        }
    }
    return false;
}

// Returnerer deltagelsen for gitt bruker i gitt aktivitet
function hentDeltagelse($bruker, $aktivitet)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        $deltagelse = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $deltagelse = $deltagelse->where("Bruker", "LIKE", $bruker)->first();
        
        if($deltagelse !== null)
        {
            return $deltagelse->Deltagelse;
        }
    }
    return 0;
}

// Stemmer