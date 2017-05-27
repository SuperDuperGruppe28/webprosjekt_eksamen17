<?php
require_once __DIR__ . '/../database/tools/bruker.php';
require_once __DIR__ . '/../database/tools/kommentar.php';

$bruker = loggetInnBruker();

// Konstanter
$PTekst = "tekst";
$PAktivitet = "aktivitet";
$PKommentar = "kommentar";

$GAction = "action";
$GPost = "post";
$GEdit = "edit";
$GDelete = "del";
$GKommentar = "kommentar";
$GAktivitet = "aktivitet";

// Om bruker er logget inn
if ($bruker) {
    $action = $_GET[$GAction];

    // Poste kommentar
    if ($action === $GPost) {
        if (isset($_POST[$PTekst]) && isset($_POST[$PAktivitet])) 
        {
            if(kommentarDataValid($_POST[$PTekst]))
                postKommentar($bruker, $_POST[$PAktivitet], $_POST[$PTekst]);
        } else {
            echo "Mangler data";
        }
        // Redigere kommentar
    } else if ($action === $GEdit) {
        if (isset($_POST[$PTekst]) && isset($_POST[$PKommentar])) {
            // bare admin eller eieren av kommentaren kan redigere kommentar
            if (erAdmin($bruker) || finnKommentarEier($_POST[$PKommentar]) === $bruker) 
            {
                if(kommentarDataValid($_POST[$PTekst]))
                    redigerKommentar($_POST[$PKommentar], $_POST[$PTekst]);
            }
        } else {
            echo "Mangler data";
        }
        // Slette kommentar
    } else if ($action === $GDelete) {
        if (isset($_GET[$GKommentar])) {
            // bare admin eller eieren av kommentaren kan slette kommentar
            if (erAdmin($bruker) || finnKommentarEier($_GET[$GKommentar]) === $bruker)
            {
                slettKommentar($_GET[$GKommentar]);
            }
        } else {
            echo "Mangler data";
        }
    }
} else {
    echo "<h1>Må være logget inn!</h1>";
}

$akt = "0";
if (!isset($_POST[$PAktivitet]))
    $akt = $_GET[$GAktivitet];
else
    $akt = $_POST[$PAktivitet];


// Sender tilbake til forrige side
echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id='.$akt.'"/></head></html>';

// Validerer inputdataen før spørring
function kommentarDataValid($tekst)
{
    if($tekst === "")
        return false;
    if(strlen($tekst) > 512)
        return false;
        
    return true;
}
