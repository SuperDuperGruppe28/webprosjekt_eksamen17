<?php

$PSok = "sok";

if(isset($_POST[$PSok]))
{
    echo '<div class="center">';
    echo "<h1>Aktiviteter</h1>";
    foreach(sokAktivitet($_POST[$PSok]) as $res)
    {
        printAktivitetBoksFraArray($res);
    }
    echo "<h1>Brukere</h1>";
    foreach(sokBruker($_POST[$PSok]) as $res)
    {
        printBrukerBoksFraArray($res->Brukernavn);
    }
    echo '</div>';
}else
{
    echo "Mangler søk..";
}