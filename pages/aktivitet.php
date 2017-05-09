<div id="aktivitetBoks">
    
    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            if(eksistererAktivitet($id))
            {
                $akt = hentAktivitet($id);
                $tags = hentAktivitetTags($id);
                echo "<h1>" . $akt->Tittel . "</h1>";
                echo "<b>Sjef: " . $akt->Bruker . "</b><br>";
                echo "<b>" . $akt->Beskrivelse . "</b><br>";
                echo "<b>" . $akt->Apningstider . "</b><br>";
                echo "<b>" . $akt->Dato . "</b><br>";
                echo "<b>" . $akt->Pris . "kr</b><br>";
                echo '<img src="'.$akt->Bilde.'" height="100px width="100px"/><br>';
                foreach($tags as $tag)
                        {
                            echo "<b>" . $tag->Tag . " = " . $tag->Vekt . "%</b>, ";
                        }
                
                // Kommentarfelt
                $brukernavn = loggetInnBruker();
                // Sjekke om bruker er logget inn
                if($brukernavn)
                {
                ?>
                    <h1>Post kommentar</h1>
                    <form action="php/comment.php?action=post" method="post">
                        <textarea id="tekst" name="tekst" rows="5" cols="70"></textarea><br/><br/>
                        <input type="hidden" id="aktivitet" name="aktivitet" value="<?=$id?>" />            
                        <input class="button" type="submit" value="post kommentar"/>
                    </form>

                <?php
                }
                    echo "<h1>Kommentarer</h1>";
                    foreach(hentKommentarer($id) as $kom)
                    {
                        echo "<b>" . $kom->Dato . " - " . $kom->Bruker . "</b>: " . $kom->Tekst;
                        echo "<br>";
                    }
                
                
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
            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel" placeholder="Tittel.."><br/><br/>
            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20" cols="100" placeholder="Beskrivelse.."></textarea><br/><br/>
            <label for="apning">Åpning</label> <input type="text" id="apning" name="apning"><br/><br/>
            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato"><br><br>
            <label for="pris">Pris</label> <input type="number" id="pris" name="pris"><br/><br/>
            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"><br/><br/>
            
            <!--Koordinater for GOOGLE MAPS KART-->
            <input type = "hidden" id = "lengdegrad" name="lengdegrad" value = "0" />
            <input type = "hidden" id = "breddegrad" name="breddegrad" value = "0" />
            
            <?php
            if(erAdmin($brukernavn))
                echo '<label for="statisk">Statisk</label> <input type="number" id="statisk" name="statisk"><br/><br/>';    
            ?>
            
            <!--TAGS-->
            <h3>Tags - Vekt</h3>
            <input class="inputTag" type="text" id="tag_1" name="tag_1"><input class="inputTag" type="number" id="tag_vekt1" name="tag_vekt1"><br>
           <input class="inputTag" type="text" id="tag_2" name="tag_2"><input class="inputTag" type="number" id="tag_vekt2" name="tag_vekt2"><br>
            <input class="inputTag" type="text" id="tag_3" name="tag_3"><input class="inputTag" type="number" id="tag_vekt3" name="tag_vekt3"><br>
            
            <input class="button" type="submit" value="Registrer aktivitet"/>
        </form>
    <?php
            }else
            {
                echo "<h1>Logg inn for å opprette en ny aktivitet!";
            }
        }
    ?>
</div>	