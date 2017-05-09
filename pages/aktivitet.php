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
            $brukernavn = loggetInnBruker();
            if($brukernavn)
            {?>
             <h1>Lag ny aktivitet</h1>
        <form action="php/activity.php?action=reg" method="post">
            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel"><br/><br/>
            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20" cols="100"></textarea><br/><br/>
            <label for="apning">Åpning</label> <input type="text" id="apning" name="apning"><br/><br/>
            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato"><br><br>
            <label for="pris">Pris</label> <input type="number" id="pris" name="pris"><br/><br/>
            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"><br/><br/>
            <input type = "hidden" id = "lengdegrad" name="lengdegrad" value = "0" />
            <input type = "hidden" id = "breddegrad" name="breddegrad" value = "0" />
            
            <?php
            if(erAdmin($brukernavn))
                echo '<label for="statisk">Statisk</label> <input type="number" id="statisk" name="statisk"><br/><br/>';    
            ?>
            <input class="button" type="submit" value="Registrer aktivitet"/>
        </form>
    <?php
            }else
            {
                echo "<h1>Logg inn for å opprette en ny aktivitet!";
            }
        }
    ?>
    
        <h1>Post kommentar</h1>
        <form action="php/comment.php?action=post" method="post">
            <label for="tekst">Tekst</label> <textarea id="tekst" name="tekst" rows="5" cols="70"></textarea><br/><br/>
            <input type="hidden" id="aktivitet" name="aktivitet" value="<?=$id?>" />            
            <button type = "submit">post kommentar</button>
        </form>
    
    <?php
        echo "<h1>Kommentarer</h1>";
        foreach(hentKommentarer($id) as $kom)
        {
            echo $kom->Bruker . ": " . $kom->Tekst;
            echo "<br>";
        }
    ?>

</div>	