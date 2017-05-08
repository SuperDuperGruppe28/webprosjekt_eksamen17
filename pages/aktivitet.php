<div id="aktivitetBoks">
    
    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            if(eksistererAktivitet($id))
            {
                $akt = hentAktivitet($id);
                echo "<h1>" . $akt->Tittel . "</h1>";
                echo "<b>Sjef: " . $akt->Bruker . "</b><br>";
                echo "<b>" . $akt->Beskrivelse . "</b><br>";
                echo "<b>" . $akt->Apningstider . "</b><br>";
                echo "<b>" . $akt->Dato . "</b><br>";
                echo "<b>" . $akt->Pris . "kr</b><br>";
                echo '<img src="'.$akt->Bilde.'" height="100px width="100px"/>';
                
            }else
            {
                echo "<h1>Aktivitet med id " . $_GET['id'] . " eksisterer ikke!</h1>";
            }
        }else
        {
            
        }
    ?>

</div>	