<?php
        if(isset($_GET['tag']))
        {
            $id = $_GET['tag'];
            
            echo "<h3>Aktiviteter fra ".$id."</h3>";
            
            foreach(hentAktiviteterFraTag($id) as $akt)
            {
                printAktivitetBoks($akt->id);
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



?>