<?php

$PSok = "sok";

if (isset($_POST[$PSok])) {
    echo '<div class="center">';
    echo "<h1>Aktiviteter</h1>";
    $aktitviteter = sokAktivitet($_POST[$PSok]);

    if (count($aktitviteter) > 0) {
        foreach ($aktitviteter as $res) {
            printAktivitetBoksFraArray($res);
        }
    } else
        echo "Finner ingen aktiviteter..";
    echo "<h1>Brukere</h1>";
    $brukere = sokBruker($_POST[$PSok]);
    if (count($brukere) > 0) {
        echo "<div style='display: inline-block;text-align: left;'>";
        foreach ($brukere as $res) {
            printBrukerBoksFraArray($res->Brukernavn);
        }
        echo '</div>';
    } else
        echo "Finner ingen brukere..";

    echo '</div>';
} else {
    echo "Mangler søk..";
}