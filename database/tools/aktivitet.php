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

function eksistererAktivitet($aktivitet)
{
    return (Aktivitet::find($aktivitet)) !== null ? true : false;   
}

function hentAktivitetKommentarfelt($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $kommentarfelt = Aktivitet::find(1)->kommentarfelt->where("Aktivitet", "=", $aktivitet)->first();
        return $kommentarfelt->id;
    }
    return -1;
}

// skape aktivitet

// Slette aktivitet

// Redigere aktivitet

// Deltagelse

// Stemmer