<?php
require_once __DIR__ . '/../database/tools/bruker.php';

// Konstanter
$PVerifisert = "ver";
$PUser = "user";

// Om action er valgt
if (isset($_GET[$PVerifisert]) && isset($_GET[$PUser])) {
    $user = $_GET[$PUser];
    $verification = $_GET[$PVerifisert];

    if (!erVerifisert($user)) {
        if (hentVerifikasjonsHash($user) === $verification) {
            settVerifisert($user, 1);
            echo "<h1>" . $user . " har blitt verifisert!</h1>";
        } else {
            echo "<h1>Verifikasjonskoden stemmer ikke!</h1>";
        }
    } else {
        echo "<h1>" . $user . " er allerede verifisert!</h1>";
    }

} else {
    echo "<h1>Mangler data!</h1>";
}