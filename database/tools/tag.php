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

// Registrerer ny tag på aktivitet
function registrerAktivitetTag($aktivitet, $tag, $vekt)
{
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