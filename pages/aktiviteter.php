<?php
        echo '<div id="center">';
        if(isset($_GET['tag']))
        {
            $tag = $_GET['tag'];
            
            echo "<h3>Aktiviteter fra ".$tag."</h3>";
            
            
            foreach(hentAktiviteterFraTag($tag) as $akt)
            {
                printAktivitetBoks($akt->Aktivitet);
            }
           
        }else
        {
            // printer alle aktivitetene
       
            echo "<h3>Aktiviteter</h3>";
            foreach(hentAlleAktiviteter() as $akt)
            {
                printAktivitetBoks($akt->id);
            }
            
        }
        echo "</div>";
?>