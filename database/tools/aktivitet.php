<?php
//       _    _    _   _       _ _       _   
//      / \  | | _| |_(_)_   _(_) |_ ___| |_ 
//     / _ \ | |/ / __| \ \ / / | __/ _ \ __|
//    / ___ \|   <| |_| |\ V /| | ||  __/ |_ 
//   /_/   \_\_|\_\\__|_| \_/ |_|\__\___|\__|
//                                           
require_once __DIR__  . '/../models.php';
require_once "bruker.php";
require_once "kommentar.php";


$AKTIVITETER_SIDE = 10;

// Oppretter en ny aktivitet
// Todo
// Legge til tags, eller håndtere det i aktivitetskapelseforalle.php
function skapAktivitet($bruker, $tittel, $beskrivelse, $apning, $dato, $pris, $statisk, $bilde, $lon, $lat)
{
    if (eksistererBruker($bruker)) {
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
        return $akti->id;
    }
    return false;
}

// Sletter aktivtet og relasjoner
function slettAktivitet($aktivitet)
{
    if (eksistererAktivitet($aktivitet)) {
        $akt = Aktivitet::find($aktivitet);
        slettAktivitetTag($aktivitet);
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
    if (eksistererAktivitet($aktivitet)) {
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

// Returnerer aktivitet med aktivitetsID
function hentAlleAktiviteter()
{
    return Aktivitet::All()->sortByDesc("Dato");
}

//Redigerer aktivteten
function redigerAktivitet($aktivitet, $tittel, $beskrivelse, $dato, $pris, $statisk, $bilde, $lon, $lat)
{
    if (eksistererAktivitet($aktivitet)) {
        $akti = hentAktivitet($aktivitet);
        $akti->Tittel = $tittel;
        $akti->Beskrivelse = $beskrivelse;
        $akti->Dato = date("Y-m-d H:i:s", strtotime($dato));
        $akti->Pris = $pris;
        $akti->Statisk = $statisk;
        $akti->Bilde = $bilde;
        $akti->Lengdegrad = $lon;
        $akti->Breddegrad = $lat;
        $akti->save();

        // Oppretter kommentarfelt for aktivitet
        return true;
    }
    return false;
}

// Printer ut en liten Aktivitetsboks fra gitt aktivitet
function printAktivitetBoks($aktivitet)
{
    if (eksistererAktivitet($aktivitet)) {
        $akt = hentAktivitet($aktivitet);
        $pris = $akt->Pris > 0 ? $akt->Pris . "kr" : "Gratis!";
        $dato = new Carbon\Carbon($akt->Dato);
        $dato = $dato->diffForHumans();
        if ($akt->Statisk === 1)
            $dato = "Statisk";
        ?>
        <div class="AktivitetLitenBoks">
            <a href="?side=aktivitet&id=<?= tryggPrint($aktivitet) ?>">
                <img class="bildeBoks" src="<?= tryggPrint($akt->Bilde) ?>" onerror="this.src='img/default_aktivitet.png'"/>
                <div class="bildeBoksLag"></div>
            </a>
            <div class="Tittel"><b><?= tryggPrint($akt->Tittel) ?></b></div>
            <a href="?side=bruker&id=<?= tryggPrint($akt->Bruker) ?>">
                <div class="Utgiver">
                    <b><?= tryggPrint($akt->Bruker) ?></b>
                    <img class="Ikoner" src="<?= hentBrukerBildeEx($akt->Bruker) ?>"</img>
                </div>
            </a>
            <div class="Dato"><?= $dato ?></div>
            <div class="Likes">
                <b><?= tryggPrint(antallStemmer($aktivitet)) ?></b>
                <img class="Ikoner"
                     src="https://cdn0.iconfinder.com/data/icons/basic-ui-elements-colored/700/08_heart-2-512.png"</img>
            </div>
            <div class="Beskrivelse"><?= tryggPrint($akt->Beskrivelse) ?></div>
            <div class="Pris"><?= $pris ?></div>
        </div>

        <?php
    } else {
        echo "Fant ikke aktivtet: " . $aktivitet;
    }
}

function printAktivitetBoksFraArray($aktivitet)
{
    $akt = $aktivitet;
    $pris = $akt->Pris > 0 ? $akt->Pris . "kr" : "Gratis!";
    $dato = new Carbon\Carbon($akt->Dato);
    $dato = $dato->diffForHumans();
    if ($akt->Statisk === 1)
        $dato = "Statisk";
    ?>
    <div class="AktivitetLitenBoks">
        <a href="?side=aktivitet&id=<?= tryggPrint($aktivitet->id) ?>">
            <img class="bildeBoks" src="<?= tryggPrint($akt->Bilde) ?>" onerror="this.src='img/default_aktivitet.png'"/>
            <div class="bildeBoksLag"></div>
        </a>
        <div class="Tittel"><b><?= tryggPrint($akt->Tittel) ?></b></div>
        <a href="?side=bruker&id=<?= tryggPrint($akt->Bruker) ?>">
            <div class="Utgiver">
                <b><?= tryggPrint($akt->Bruker) ?></b>
                <img class="Ikoner" src="<?= hentBrukerBildeEx($akt->Bruker) ?>"</img>
            </div>
        </a>
        <div class="Dato"><?= $dato ?></div>
        <div class="Likes">
            <b><?= tryggPrint(antallStemmer($aktivitet->id)) ?></b>
            <img class="Ikoner"
                 src="https://cdn0.iconfinder.com/data/icons/basic-ui-elements-colored/700/08_heart-2-512.png"</img>
        </div>
        <div class="Beskrivelse"><?= tryggPrint($akt->Beskrivelse) ?></div>
        <div class="Pris"><?= $pris ?></div>
    </div>
    <?php
}

// Returner resultat fra søk
function sokAktivitet($sok)
{
    return Aktivitet::where(function ($query) use ($sok) {
        $query->where('id', '=', $sok)
            ->orWhere('Tittel', 'LIKE', "%" . $sok . "%")
            ->orWhere('Bruker', 'LIKE', "%" . $sok . "%");
    })->get(); //->unique();   
}

// Henter ut statiske aktiviteter, paged
function hentStatiskeAktiviteter($side)
{
    global $AKTIVITETER_SIDE;
    $akt = Aktivitet::where("Statisk", "=", 1)->skip($side * $AKTIVITETER_SIDE)->take($AKTIVITETER_SIDE)->get();
    return $akt;
}

// Henter ut alle aktiviteter, paged
function hentAktiviteterFraSide($side)
{
    global $AKTIVITETER_SIDE;
    $akt = Aktivitet::skip($side * $AKTIVITETER_SIDE)->take($AKTIVITETER_SIDE)->get();
    return $akt;
}

// henter de nyeste aktivitetene
function hentNyesteAktiviteter($antall)
{
    $akt = Aktivitet::orderBy('Registrert', 'desc')->take($antall)->get();
    return $akt;
}

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
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        // Om brukeren allerede deltar i aktivtet, ikke lag ny
        if (hentDeltagelse($bruker, $aktivitet) <= 0) {
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
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        $deltagelse = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $deltagelse = $deltagelse->where("Bruker", "LIKE", $bruker)->first();

        if ($deltagelse !== null) {
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
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        $deltagelse = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $deltagelse = $deltagelse->where("Bruker", "LIKE", $bruker)->first();

        if ($deltagelse !== null) {
            return $deltagelse->Deltagelse;
        }
    }
    return -1;
}

// Returnerer deltagelsen for gitt bruker i gitt aktivitet
function hentAntallDeltagelser($aktivitet, $delta)
{
    if (eksistererAktivitet($aktivitet)) {
        $deltagelse = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $deltagelse = $deltagelse->where("Deltagelse", "=", $delta)->get();

        if ($deltagelse !== null) {
            return count($deltagelse);
        }
    }
    return 0;
}

// Sletter stemme for bruker i gitt aktivtet
function slettDeltagelse($bruker, $aktivitet)
{
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        if (hentDeltagelse($bruker, $aktivitet) !== null) {
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
    if (eksistererAktivitet($aktivitet)) {
        $delta = Deltagelse::where("Aktivitet", "=", $aktivitet);
        $delta->delete();

        return true;
    }
    return false;
}

// Returnerer aktivtene en bruker deltar i
function hentBrukerDeltagelser($bruker, $deltagelse)
{
    if (eksistererBruker($bruker)) {
        $delta = Deltagelse::where("Bruker", "LIKE", $bruker);
        return $delta->where("Deltagelse", "=", $deltagelse)->get();
    }
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
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        // Om brukeren allerede har stemt ikke lag ny
        if (!harStemtAktivitet($bruker, $aktivitet)) {
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
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        $stem = Stemmer::where("Aktivitet", "=", $aktivitet);
        $stem = $stem->where("Bruker", "LIKE", $bruker)->first();

        if ($stem !== null) {
            return true;
        }
    }
    return false;
}

// Sletter stemme for bruker i gitt aktivtet
function slettStemme($bruker, $aktivitet)
{
    if (eksistererAktivitet($aktivitet) && eksistererBruker($bruker)) {
        if (harStemtAktivitet($bruker, $aktivitet)) {
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
    if (eksistererAktivitet($aktivitet)) {
        $stem = Stemmer::where("Aktivitet", "=", $aktivitet);
        $stem->delete();

        return true;
    }
    return false;
}

// Returner antall stemmer en aktivitet har
function antallStemmer($aktivitet)
{
    if (eksistererAktivitet($aktivitet)) {
        return count(Stemmer::where("Aktivitet", "=", $aktivitet)->get());
    }
    return false;
}