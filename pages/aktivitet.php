<!--Javscript Map-->
    <script type="text/javascript">
        //google.maps.event.addDomListener(window, 'load', init);
        
        function startMaps(x, y, side)
        {
             var mapOptions = 
                {
                    zoom: 14,

                    center: new google.maps.LatLng(x, y), // Vulkan, Oslo
                    styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
                };
                
                var mapElement = document.getElementById('mapaktivitet');
                var map = new google.maps.Map(mapElement, mapOptions);
                    marker = new google.maps.Marker({
                    position: new google.maps.LatLng(x, y),
                    map: map,
                    draggable:side,
                    title: 'Vulkan'
                });
                
                if(side)
                {
                    google.maps.event.addListener(marker, 'dragend', function() {settKoordinater(marker.getPosition().lat(), marker.getPosition().lng())});
                    settKoordinater(marker.getPosition().lat(), marker.getPosition().lng());     
                } 
        }
        
        // Setter koordinatene fra map til Post submit
        function settKoordinater(x,y)
        {
            console.log("x: " + x + " Y: " + y );
            document.getElementById("breddegrad").value = x;
            document.getElementById("lengdegrad").value = y;
        }
        
        </script>

<div id="aktivitetBoks">
    
    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            if(eksistererAktivitet($id))
            {
                $akt = hentAktivitet($id);
                if(!isset($_GET['action']))
                {
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

                echo "<br><b>Likes: </b>" . antallStemmer($id);
                
                echo "<br><b>Deltar ikke: </b>" . hentAntallDeltagelser($id, 0);
                echo "<br><b>Deltar: </b>" . hentAntallDeltagelser($id, 1);
                echo "<br><b>Deltar kanskje: </b>" . hentAntallDeltagelser($id, 2);
                
                $brukernavn = loggetInnBruker();
                if($brukernavn)
                {
                ?><form action="php/activity.php?action=stem&akti=<?=$id?>" method="post">
                        <input type="submit" value="<?=!harStemtAktivitet($brukernavn, $id)? 'Liker!' : 'Liker ikke!';?>" />
                </form>
    
                <select name="deltagelse" form="deltaform">
                  <option value="0" <?= hentDeltagelse($brukernavn, $id) === 0 ? ' selected="selected"' : '';?>>Deltar ikke</option>
                  <option value="1" <?= hentDeltagelse($brukernavn, $id) === 1 ? ' selected="selected"' : '';?>>Deltar</option>
                  <option value="2" <?= hentDeltagelse($brukernavn, $id) === 2 ? ' selected="selected"' : '';?>>Deltar kanskje</option>
                </select>
                <form action="php/activity.php?action=delta&akti=<?=$id?>" method="post" id="deltaform">
                        
                        <input type="submit" value="Velg deltagelse" />
                </form>
    
                <select name="deltagelse" form="deltaform">
                  <option value="0" <?= hentDeltagelse($brukernavn, $id) === 0 ? ' selected="selected"' : '';?>>Deltar ikke</option>
                  <option value="1" <?= hentDeltagelse($brukernavn, $id) === 1 ? ' selected="selected"' : '';?>>Deltar</option>
                  <option value="2" <?= hentDeltagelse($brukernavn, $id) === 2 ? ' selected="selected"' : '';?>>Deltar kanskje</option>
                </select>
                <form action="php/activity.php?action=delta&akti=<?=$id?>" method="post" id="deltaform">
                        
                        <input type="submit" value="Velg deltagelse" />
                </form>
                <?php
                }
                echo "<div id='mapaktivitet'></div>";
                
                //<!--Laste google maps-->
                echo "<script type='text/javascript'>startMaps(" . $akt->Breddegrad . ", " . $akt->Lengdegrad . ", false) </script>";
                
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
                    
                // Redigeringsside
                }else
                {
                        $brukernavn = loggetInnBruker();
                        if($brukernavn)
                        {
                            if($brukernavn === $akt->Bruker)
                            {
                                
                            
                            ?>
                             <h1>Rediger <?=$akt->Tittel?></h1>
                        <form action="php/activity.php?action=edit&akti=<?=$id?>" method="post">
                            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel" placeholder="Tittel.." value="<?=$akt->Tittel;?>"><br/><br/>
                            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20" cols="100" placeholder="Beskrivelse.."><?=$akt->Beskrivelse;?></textarea><br/><br/>
                            <?php $dato =  new DateTime($akt->Dato); ?>
                            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato" value="<?=$dato->format('Y-m-d\TH:i:s');?>"><br><br>
                            <label for="pris">Pris</label> <input type="number" id="pris" name="pris" value="<?=$akt->Pris;?>"><br/><br/>
                            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde" value="<?=$akt->Bilde;?>"><br/><br/>

                            <!--Koordinater for GOOGLE MAPS KART-->
                            <input type="hidden" id="lengdegrad" name="lengdegrad" value="<?=$akt->Lengdegrad;?>" />
                            <input type="hidden" id="breddegrad" name="breddegrad" value="<?=$akt->Breddegrad;?>" />

                            <?php
                            if(erAdmin($brukernavn))
                                echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk"' . ($akt->Statisk === 1 ? 'checked="checked"' : '') . '><br/><br/>';    
                            ?>

                            <div id="mapaktivitet"></div>
                            <!--Laste google maps-->
                            <script type='text/javascript'>startMaps(<?=$akt->Lengdegrad;?>, <?=$akt->Breddegrad;?>, true); </script>

                            <input class="button" type="submit" value="Registrer redigering"/>
                        </form>

                    <?php
                            }
                            else
                                echo "<h1>HEY DETTE ER IKKE DIN SIDE!</h1>";
                        }else
                        {
                            echo "<h1>Logg inn for å opprette en ny aktivitet!";
                        }
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
            <input type="hidden" id="apning" name="apning" value="">
            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato"><br><br>
            <label for="pris">Pris</label> <input type="number" id="pris" name="pris"><br/><br/>
            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"><br/><br/>
            
            <!--Koordinater for GOOGLE MAPS KART-->
            <input type="hidden" id="lengdegrad" name="lengdegrad" value = "0" />
            <input type="hidden" id= "breddegrad" name="breddegrad" value = "0" />
            
            <?php
            if(erAdmin($brukernavn))
                echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk" value="1"><br/><br/>';    
            ?>
            
            <div id="mapaktivitet"></div>
            <!--Laste google maps-->
            <script type='text/javascript'>startMaps(59.922425, 10.751672, true); </script>
            
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