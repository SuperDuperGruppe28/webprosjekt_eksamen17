<?php
//   _________               
//  |  _   _  |              
//  |_/ | | \_|,--.   .--./) 
//      | |   `'_\ : / /'`\; 
//     _| |_  // | |,\ \._// 
//    |_____| \'-;__/.',__`  
//                  ( ( __)) 

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/models.php';
require_once "bruker.php";

// Registerer en ny tag
function registrerTag($tag)
{
    if(!eksistererTag($tag))
    {
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
    if(!eksistererTag($tag)
        registrerTag($tag);
       
    if(eksistererTag($tag) && !eksistererBrukerTag($tag) && eksistererBruker($bruker))
    {
        $tags = new TagsBruker();
        $tags->Tag = $tag;
        $tags->Bruker = $bruker;
        $tags->Score = $score;
        $tags->save();
        
        return true;
    }
    return false;
}

// Sjekker om en tag eksisterer
function eksistererBrukerTag($tag)
{
    return (TagsBruker::where("Tag", "LIKE", $tag)->first()) !== null ? true : false;
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

// Registrerer ny tag på aktivitet
function registrerAktivitetTag($aktivitet, $tag, $vekt)
{
    if(!eksistererTag($tag)
        registrerTag($tag);
       
    if(eksistererTag($tag) && !eksistererAktivitetTag($tag)) //  Sjekke om aktivitet eksisterer
    {
        $tags = new TagsAktivitet();
        $tags->Tag = $tag;
        $tags->Bruker = $bruker;
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