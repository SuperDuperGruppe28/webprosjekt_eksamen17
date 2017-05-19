<div id="aktivitetBoks">

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (eksistererAktivitet($id)) {
            $akt = hentAktivitet($id);
            if (!isset($_GET['action'])) {
                $tags = hentAktivitetTags($id);
                
                $dato = $akt->Dato;
                if ($akt->Statisk === 1)
                    $dato = "Statisk";
                ?>

                <h1><?= tryggPrint($akt->Tittel); ?></h1>
                <img style="width:100%; height:100%;" src="<?= tryggPrint($akt->Bilde); ?>"/>
                <a href="?side=bruker&id=<?= $akt->Bruker ?>"><img height='40px' width='40px'
                                                                   src="<?= hentBrukerBildeEx($akt->Bruker) ?>"/><?= $akt->Bruker ?>
                </a><br>
                <b>Dato: <?= $dato ?></b><br>
                <b>Beskrivelse: <?= tryggPrint($akt->Beskrivelse); ?></b><br>
                <b>Statisk: <?= $akt->Statisk ?></b><br>

                <?php
                foreach ($tags as $tag) {
                    echo "<b>" . tryggPrint($tag->Tag) . " = " . tryggPrint($tag->Vekt) . "%</b>, ";
                }

                echo "<br><b>Likes: </b>" . tryggPrint(antallStemmer($id));

                echo "<br><b>Deltar ikke: </b>" . tryggPrint(hentAntallDeltagelser($id, 0));
                echo "<br><b>Deltar: </b>" . tryggPrint(hentAntallDeltagelser($id, 1));
                echo "<br><b>Deltar kanskje: </b>" . tryggPrint(hentAntallDeltagelser($id, 2));
                $brukernavn = loggetInnBruker();
                if ($brukernavn) {
                    // Loggføre besøket til brukeren
                    foreach (hentAktivitetTags($id) as $akTag) {
                        registrerBrukerBesok($brukernavn, $akTag->Tag);
                    }

                    if ($brukernavn === $akt->Bruker || erAdmin($brukernavn)) {
                        echo '<form action="?side=aktivitet&action=edit&id=' . $id . '" method="post">
                        
                            <input type="submit" value="Rediger aktivitet" />
                        </form>';
                    }

                    ?>
                    <form action="php/activity.php?action=stem&akti=<?= $id ?>" method="post">
                    <input type="submit"
                           value="<?= !harStemtAktivitet($brukernavn, $id) ? 'Liker!' : 'Liker ikke!'; ?>"/>
                    </form>

                    <select name="deltagelse" form="deltaform">
                        <option value="0" <?= hentDeltagelse($brukernavn, $id) === 0 ? ' selected="selected"' : ''; ?>>
                            Deltar ikke
                        </option>
                        <option value="1" <?= hentDeltagelse($brukernavn, $id) === 1 ? ' selected="selected"' : ''; ?>>
                            Deltar
                        </option>
                        <option value="2" <?= hentDeltagelse($brukernavn, $id) === 2 ? ' selected="selected"' : ''; ?>>
                            Deltar kanskje
                        </option>
                    </select>
                    <form action="php/activity.php?action=delta&akti=<?= $id ?>" method="post" id="deltaform">

                        <input type="submit" value="Velg deltagelse"/>
                    </form>
                    <?php
                }


                echo "<div id='mapaktivitet'></div>";

                //<!--Laste google maps-->
                echo "<script type='text/javascript'>startMaps(" . $akt->Breddegrad . ", " . $akt->Lengdegrad . ", false) </script>";

                // Kommentarfelt
                $brukernavn = loggetInnBruker();
                // Sjekke om bruker er logget inn
                if ($brukernavn) {
                    ?>
                    <h1>Post kommentar</h1>
                    <form action="php/comment.php?action=post" method="post">
                        <textarea id="tekst" name="tekst" rows="5" cols="70"></textarea><br/><br/>
                        <input type="hidden" id="aktivitet" name="aktivitet" value="<?= $id ?>"/>
                        <input class="button" type="submit" value="post kommentar"/>
                    </form>

                    <?php
                }
                echo "<div id='kommentarFelt'><h1>Kommentarer</h1>";
                $kommentarer = hentKommentarer($id);
                if(count($kommentarer) > 0)
                {
                     foreach ($kommentarer as $kom)
                     {
                        $klasse = "";
                        if (erAdmin($kom->Bruker))
                            $klasse = "adminSkrift";
                        echo "<div class='kommentar'><b>" . $kom->Dato . " - <a href='?side=bruker&id=" . $kom->Bruker . "'><img height='25px' width='25px' src='" . hentBrukerBildeEx($kom->Bruker) . "'/><b class='" . $klasse . "'>" . $kom->Bruker . "</b></a></b>: " . tryggPrint($kom->Tekst);
                        echo "</div>";
                     }
                }else
                {
                    echo "Ingen kommentarer...";
                }
               
                echo "</div>";

                // Redigeringsside
            } else {
                $brukernavn = loggetInnBruker();
                if ($brukernavn) {
                    if ($brukernavn === $akt->Bruker || erAdmin($brukernavn)) {


                        ?>
                        <h1>Rediger <?= $akt->Tittel ?></h1>
                        <form action="php/activity.php?action=edit&akti=<?= $id ?>" method="post">
                            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel"
                                                                      placeholder="Tittel.."
                                                                      value="<?= $akt->Tittel; ?>"><br/><br/>
                            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse"
                                                                                   rows="20" cols="100"
                                                                                   placeholder="Beskrivelse.."><?= $akt->Beskrivelse; ?></textarea><br/><br/>
                            <?php $dato = new DateTime($akt->Dato); ?>
                            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato"
                                                                  value="<?= $dato->format('Y-m-d\TH:i:s'); ?>"><br><br>
                            <label for="pris">Pris</label> <input type="number" id="pris" name="pris"
                                                                  value="<?= $akt->Pris; ?>"><br/><br/>
                            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"
                                                                    value="<?= $akt->Bilde; ?>"><br/><br/>

                            <!--Koordinater for GOOGLE MAPS KART-->
                            <input type="hidden" id="lengdegrad" name="lengdegrad" value="<?= $akt->Lengdegrad; ?>"/>
                            <input type="hidden" id="breddegrad" name="breddegrad" value="<?= $akt->Breddegrad; ?>"/>

                            <?php
                            if (erAdmin($brukernavn))
                                echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk"' . ($akt->Statisk === 1 ? 'checked="checked"' : '') . '><br/><br/>';
                            ?>

                            <div id="mapaktivitet"></div>
                            <!--Laste google maps-->
                            <script type='text/javascript'>startMaps(<?=$akt->Breddegrad;?>, <?=$akt->Lengdegrad;?>, true); </script>

                            <input class="button" type="submit" value="Registrer redigering"/>
                        </form>

                        <?php
                    } else
                        echo "<h1>HEY DETTE ER IKKE DIN SIDE!</h1>";
                } else {
                    echo "<h1>Logg inn for å opprette en ny aktivitet!";
                }
            }
        } else {
            echo "<h1>Aktivitet med id " . $_GET['id'] . " eksisterer ikke!</h1>";
        }
    } else {
        $brukernavn = loggetInnBruker();
        if ($brukernavn) {
            ?>
            <h1>Lag ny aktivitet</h1>
            <form action="php/activity.php?action=reg" method="post">
                <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel"
                                                          placeholder="Tittel.."><br/><br/>
                <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20"
                                                                       cols="100"
                                                                       placeholder="Beskrivelse.."></textarea><br/><br/>
                <input type="hidden" id="apning" name="apning" value="">
                <?php $dato = new DateTime(); ?>
                <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato"
                                                      value="<?= $dato->format('Y-m-d\TH:i:s'); ?>"><br><br>
                <label for="pris">Pris</label> <input type="number" id="pris" name="pris"><br/><br/>
                <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"><br/><br/>

                <!--Koordinater for GOOGLE MAPS KART-->
                <input type="hidden" id="lengdegrad" name="lengdegrad" value="0"/>
                <input type="hidden" id="breddegrad" name="breddegrad" value="0"/>

                <?php
                if (erAdmin($brukernavn))
                    echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk" value="1"><br/><br/>';
                ?>

                <div id="mapaktivitet"></div>
                <!--Laste google maps-->
                <script type='text/javascript'>startMaps(59.922425, 10.751672, true); </script>

                <!--TAGS-->
                <h3>Tags - Vekt</h3>
                <input class="inputTag" type="text" id="tag_1" name="tag_1"><input class="inputTag" type="number"
                                                                                   id="tag_vekt1" name="tag_vekt1"><br>
                <input class="inputTag" type="text" id="tag_2" name="tag_2"><input class="inputTag" type="number"
                                                                                   id="tag_vekt2" name="tag_vekt2"><br>
                <input class="inputTag" type="text" id="tag_3" name="tag_3"><input class="inputTag" type="number"
                                                                                   id="tag_vekt3" name="tag_vekt3"><br>

                <input class="button" type="submit" value="Registrer aktivitet"/>
            </form>

            <?php
        } else {
            echo "<h1>Logg inn for å opprette en ny aktivitet!";
        }
    }
    ?>
</div>	