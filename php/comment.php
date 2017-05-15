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

// Om bruker er logget inn
if ($bruker) {
    $action = $_GET[$GAction];

    // Poste kommentar
    if ($action === $GPost) {
        if (isset($_POST[$PTekst]) && isset($_POST[$PAktivitet])) {
            postKommentar($bruker, $_POST[$PAktivitet], $_POST[$PTekst]);
        } else {
            echo "Mangler data";
        }
        // Redigere kommentar
    } else if ($action === $GEdit) {
        if (isset($_POST[$PTekst]) && isset($_POST[$PKommentar])) {
            // bare admin eller eieren av kommentaren kan redigere kommentar
            if (erAdmin($bruker) || finnKommentarEier($_POST[$PKommentar]) === $bruker) {
                redigerKommentar($_POST[$PKommentar], $_POST[$PTekst]);
            }
        } else {
            echo "Mangler data";
        }
        // Slette kommentar
    } else if ($action === $GDelete) {
        if (isset($_POST[$PKommentar])) {
            // bare admin eller eieren av kommentaren kan slette kommentar
            if (erAdmin($bruker) || finnKommentarEier($_POST[$PKommentar]) === $bruker) {
                slettKommentar($_POST[$PKommentar]);
            }
        } else {
            echo "Mangler data";
        }
    }
} else {
    echo "<h1>Må være logget inn!</h1>";
}

// Sender tilbake til forrige side
header('Location: ' . $_SERVER['HTTP_REFERER']);