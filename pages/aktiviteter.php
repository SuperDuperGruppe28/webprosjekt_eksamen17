<?php
        if(isset($_GET['tag']))
        {
            $id = $_GET['tag'];
        }


echo "<h3>Aktiviteter</h3>";

foreach(hentAlleAktiviteter() as $akt)
{
    printAktivitetBoks($akt->id);
}
?>