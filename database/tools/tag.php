<?php
//   _________               
//  |  _   _  |              
//  |_/ | | \_|,--.   .--./) 
//      | |   `'_\ : / /'`\; 
//     _| |_  // | |,\ \._// 
//    |_____| \'-;__/.',__`  
//                  ( ( __)) 

require_once __DIR__  . '/../models.php';
require_once "bruker.php";

// Registerer en ny tag
function registrerTag($tag)
{
    if (!eksistererTag($tag)) {
        $tags = new Tags();
        $tags->Tag = $tag;
        $tags->save();

        return true;
    }
    return false;
}

// Sjekker om en tag eksisterer
function eksistererTag($tag)
{
    return (Tags::find($tag)) !== null ? true : false;
}

// Registrerer ny tag på bruker
function registrerBrukerTag($bruker, $tag, $score)
{
    if (!eksistererTag($tag))
        registrerTag($tag);

    if (eksistererTag($tag) && eksistererBruker($bruker)) {
        $tags = new TagsBruker();
        $tags->Tag = $tag;
        $tags->Bruker = $bruker;
        $tags->Score = $score;
        $tags->save();

        return true;
    }
    return false;
}

function hentAlleTags()
{
    return Tags::All();
}

// Sjekker om en tag eksisterer
function eksistererBrukerTag($bruker, $tag)
{
    $bTag = TagsBruker::where("Tag", "LIKE", $tag);
    return ($bTag->where("Bruker", "LIKE", $bruker)->first()) !== null ? true : false;
}

// Returnerer brukertag
function hentBrukerTag($bruker, $tag)
{
    $score = TagsBruker::where("Tag", "LIKE", $tag);
    return $score->where("Bruker", "LIKE", $bruker)->first();
}

// Henter brukerens score for gitt tag
function hentBrukerTagScore($bruker, $tag)
{
    $score = TagsBruker::where("Tag", "LIKE", $tag);
    $score = $score->where("Bruker", "LIKE", $bruker)->first();
    return $score->Score;
}

// Henter brukerens besok for gitt tag
function hentBrukerTagBesok($bruker, $tag)
{
    $besok = TagsBruker::where("Tag", "LIKE", $tag);
    $besok = $besok->where("Bruker", "LIKE", $bruker)->first();
    return $besok->Besok;
}

function registrerBrukerBesok($bruker, $tag)
{
    if (!eksistererBrukerTag($bruker, $tag))
        registrerBrukerTag($bruker, $tag, 0);
    else {
        $bTag = hentBrukerTag($bruker, $tag);
        $bTag->Besok = $bTag->Besok + 1;
        $bTag->save();

        return true;
    }
    return false;
}

// Registrerer ny tag på aktivitet
function registrerAktivitetTag($aktivitet, $tag, $vekt)
{
    if (!eksistererTag($tag))
        registrerTag($tag);

    if (eksistererTag($tag) && eksistererAktivitet($aktivitet)) //  Sjekke om aktivitet eksisterer
    {
        $tags = new TagsAktivitet();
        $tags->Tag = $tag;
        $tags->Aktivitet = $aktivitet;
        $tags->Vekt = $vekt;

        $tags->save();
        return true;
    }
    return false;
}

// Sjekker om en tag eksisterer
function eksistererAktivitetTag($tag)
{
    return (TagsAktivitet::where("Tag", "LIKE", $tag)->first()) !== null ? true : false;
}

// Henter aktivitetens vekt for gitt tag
function hentAktivitetTagVekt($aktivitet, $tag)
{
    $vekt = TagsAktivitet::where("Tag", "LIKE", $tag);
    $vekt = $vekt->where("Aktivitet", "=", $aktivitet)->first();
    return $vekt->Vekt;
}

function hentAktivitetTags($aktivitet)
{
    if (eksistererAktivitet($aktivitet)) {
        $tags = TagsAktivitet::where("Aktivitet", "=", $aktivitet)->get();

        return $tags;
    }
    return false;
}

function hentAlleAktivitetTags()
{
    $tags = TagsAktivitet::All();
    return $tags;
}

function hentAktiviteterFraTag($tag, $side)
{
    global $AKTIVITETER_SIDE;
    return TagsAktivitet::where("Tag", "LIKE", $tag)->skip($side * $AKTIVITETER_SIDE)->take($AKTIVITETER_SIDE)->get();
}
