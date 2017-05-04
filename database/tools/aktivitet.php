<?php
//       _    _    _   _       _ _       _   
//      / \  | | _| |_(_)_   _(_) |_ ___| |_ 
//     / _ \ | |/ / __| \ \ / / | __/ _ \ __|
//    / ___ \|   <| |_| |\ V /| | ||  __/ |_ 
//   /_/   \_\_|\_\\__|_| \_/ |_|\__\___|\__|
//                                           

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';
require_once "bruker.php";
require_once "kommentar.php";

// Oppretter en ny aktivitet
// Todo
// Legge til tags, eller håndtere det i aktivitetskapelseforalle.php
function skapAktivitet($bruker, $tittel, $beskrivelse, $apning, $dato, $pris, $statisk, $bilde, $lon, $lat)
{
    if(eksistererBruker($bruker))
    {
        $akti = new Aktivitet();
        $akti->Bruker = $bruker;
        $akti->Tittel = $tittel;
        $akti->Beskrivelse = $beskrivelse;
        $akti->Apningstider = $apning;
        $akti->Dato = date("Y-m-d H:i:s", strtotime($dato));
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
        slettDeltagelser($aktivitet);
        slettStemmer($aktivitet);
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

// Returnerer aktivitet med aktivitetsID
function hentAktivitet($aktivitet)
{
    return Aktivitet::find($aktivitet);
}

// Redigerer tittelen til en gitt aktivitet
function redigerAktivitetTittel($aktivitet, $tittel)
{
     if(eksistererAktivitet($aktivitet))
    {
        $akt = Aktivitet::find($aktivitet);
        $akt->Tittel = $tittel;
        $akt->save();
        
        return true;
    }
    return false;
}

// Redigerer beskrivelsen til en gitt aktivitet
function redigerAktivtetBeskrivelse($aktivitet, $beskrivelse)
{
     if(eksistererAktivitet($aktivitet))
    {
        $akt = Aktivitet::find($aktivitet);
        $akt->Beskrivelse = $beskrivelse;
        $akt->save();
        
        return true;
    }
    return false;
}

// Redigerer tittelen til en gitt aktivitet
function redigerAktivitetApning($aktivitet, $apning)
{
     if(eksistererAktivitet($aktivitet))
    {
        $akt = Aktivitet::find($aktivitet);
        $akt->Apning = $apning;
        $akt->save();
        
        return true;
    }
    return false;
}

// Redigerer tittelen til en gitt aktivitet
function redigerAktivitetPris($aktivitet, $pris)
{
     if(eksistererAktivitet($aktivitet))
    {
        $akt = Aktivitet::find($aktivitet);
        $akt->Pris = $pris;
        $akt->save();
        
        return true;
    }
    return false;
}
// Todo
// Redigere aktivitetfelter

//   ______           __   _                        __                
//  |_   _ `.        [  | / |_                     [  |               
//    | | `. \ .---.  | |`| |-',--.   .--./) .---.  | |  .--.  .---.  
//    | |  | |/ /__\\ | | | | `'_\ : / /'`\;/ /__\\ | | ( (`\]/ /__\\ 
//   _| |_.' /| \__., | | | |,// | |,\ \._//| \__., | |  `'.'.| \__., 
//  |______.'  '.__.'[___]\__/\'-;__/.',__`  '.__.'[___][\__) )'.__.' 
//                                  ( ( __))                          

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

// Sletter stemme for bruker i gitt aktivtet
function slettDeltagelse($bruker, $aktivitet)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        if(hentDeltagelse($bruker, $aktivitet) <= 0)
        {
            $delta = Stemmer::where("Aktivitet", "=", $aktivitet);
            $delta = $delta->where("Bruker", "LIKE", $bruker)->first();
            $delta->delete();
            return true;
        }
    }
    return false;
}

// Sletter alle stemmer for en aktivitet
function slettDeltagelser($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $delta = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $delta->delete();
         
        return true;
    }
    return false;
}

//    ______    _                                                  
//  .' ____ \  / |_                                                
//  | (___ \_|`| |-'.---.  _ .--..--.   _ .--..--.  .---.  _ .--.  
//   _.____`.  | | / /__\\[ `.-. .-. | [ `.-. .-. |/ /__\\[ `/'`\] 
//  | \____) | | |,| \__., | | | | | |  | | | | | || \__., | |     
//   \______.' \__/ '.__.'[___||__||__][___||__||__]'.__.'[___]    
//                                                                 

// Legger til en stemme for bruker i aktivitet
function stemAktivitet($bruker, $aktivitet)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        // Om brukeren allerede har stemt ikke lag ny
        if(!harStemtAktivitet($bruker, $aktivitet))
        {
            $stem = new Stemmer();
            $stem->Bruker = $bruker;
            $stem->Aktivitet = $aktivitet;
            $stem->save();
        
            return true;
        }
    }
    return false;
}

// Returnerer deltagelsen for gitt bruker i gitt aktivitet
function harStemtAktivitet($bruker, $aktivitet)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        $stem = Stemmer::where("Aktivitet", "=", $aktivitet);
        $stem = $stem->where("Bruker", "LIKE", $bruker)->first();
        
        if($stem !== null)
        {
            return true;
        }
    }
    return false;
}

// Sletter stemme for bruker i gitt aktivtet
function slettStemme($bruker, $aktivitet)
{
    if(eksistererAktivitet($aktivitet) && eksistererBruker($bruker))
    {
        if(harStemtAktivitet($bruker, $aktivitet))
        {
            $stem = Stemmer::where("Aktivitet", "=", $aktivitet);
            $stem = $stem->where("Bruker", "LIKE", $bruker)->first();
            $stem->delete();
            return true;
        }
    }
    return false;
}

// Sletter alle stemmer for en aktivitet
function slettStemmer($aktivitet)
{
    if(eksistererAktivitet($aktivitet))
    {
        $stem = Stemmer::where("Aktivitet", "=", $aktivitet);
        $stem->delete();
         
        return true;
    }
    return false;
}