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
        $kommentarfeltId = 1;// hentAktivitetKommentarfelt($aktivitet);
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
// post kommentar

// redigere kommentar

// slette kommentar

