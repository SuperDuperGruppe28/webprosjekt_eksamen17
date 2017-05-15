<?php
        if(isset($_GET['tag']))
        {
            $tag = $_GET['tag'];
            echo "<center>";
            echo "<h3>Aktiviteter fra ".$tag."</h3>";
            
            
            foreach(hentAktiviteterFraTag($tag) as $akt)
            {
                printAktivitetBoks($akt->id);
            }
            echo "</center>";
        }else
        {
            // printer alle aktivitetene
            echo "<center>";
            echo "<h3>Aktiviteter</h3>";
            foreach(hentAlleAktiviteter() as $akt)
            {
                printAktivitetBoks($akt->id);
            }
            echo "</center>";
        }
?>