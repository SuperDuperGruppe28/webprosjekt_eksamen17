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
                    $dato = "<img class='Ikoner' height='15px' width='15px' src='img/ikon_lock.png' alt='Statisk aktiviet'/>";
                ?>

        <h1><?= tryggPrint($akt->Tittel); ?></h1>
        <?php
            if(!erVerifisert(loggetInnBruker()))
                echo "<i>Verifiser emailen din for å kommentere, like og delta i aktiviteten!</i>";
        ?>
        <img style="width:100%; height:100%;" src="<?= tryggPrint($akt->Bilde); ?>" onerror="this.src='img/default_aktivitet.png'" />
    <div class="Left"><?= $dato ?></div>
            <div class="Right"><a href="?side=bruker&id=<?= $akt->Bruker ?>"><img height='40px' width='40px' src="<?= hentBrukerBildeEx($akt->Bruker) ?>"/><?= $akt->Bruker ?></a></div>
        <br>
        <br>
        <div class="Left"><b><?=tryggPrint(antallStemmer($id))?></b><img height="20px" width="20px" src="img/ikon_hjerte.png"/></div>
        <br>
        <?php
        if ($akt->Statisk !== 1)
                {
                    echo "<b>Deltagelser</b><br><img height='20px' width='20px' src='img/ikon_deltarikke.png'/>" . tryggPrint(hentAntallDeltagelser($id, 0));
                    echo "<img height='20px' width='20px' src='img/ikon_deltar.png'/>" . tryggPrint(hentAntallDeltagelser($id, 1));
                    echo "<img height='20px' width='20px' src='img/ikon_deltarkanskje.png'/>" . tryggPrint(hentAntallDeltagelser($id, 2));
                }
        ?>
        <br>
        <br>
        <?= tryggPrint($akt->Beskrivelse); ?><br>
        <?php
                foreach ($tags as $tag) {
                    echo "<a href='?side=aktiviteter&tag=" . $tag->Tag . "'>".$tag->Tag." </a>";
                }
                
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
                         echo '<form action="php/activity.php?action=del&akti=' . $id . '" method="post">
                        
                            <input type="submit" value="Slett aktivitet" />
                        </form>';
                    }

                    // Kun verifiserte brukere kan stemme
                    if(erVerifisert($brukernavn))
                    {
                    ?>
                    <form action="php/activity.php?action=stem&akti=<?= $id ?>" method="post">
                        <input type="submit" value="<?= !harStemtAktivitet($brukernavn, $id) ? 'Liker!' : 'Liker ikke!'; ?>" />
                    </form>
                    <?php
                    }
                // Vise deltagelseknapp om aktivitet er statisk        
                if ($akt->Statisk !== 1 && erVerifisert($brukernavn))
                {?>
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

                        <input type="submit" value="Velg deltagelse" />
                    </form>
                    <?php
                }
            }


                echo "<div id='mapaktivitet'></div>";

                //<!--Laste google maps-->
                echo "<script type='text/javascript'>startMaps(" . $akt->Breddegrad . ", " . $akt->Lengdegrad . ", false) </script>";
                // Kommentarfelt
                $brukernavn = loggetInnBruker();
                // Sjekke om bruker er logget inn
                if ($brukernavn && erVerifisert($brukernavn)) {
                    ?>
                <h1>Kommentarer</h1>
                <form name="form_kommentar" action="php/comment.php?action=post" onsubmit="return validerKommentar()" method="post">
                    <textarea id="tekst" name="tekst" rows="5" cols="70"></textarea>
                    <input type="hidden" id="aktivitet" name="aktivitet" value="<?= $id ?>" />
                    <input class="button" type="submit" value="Post" />
                    <br> <br>
                </form>

                <?php
                }
                echo "<div id='kommentarFelt'>";
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
                    <h1>Rediger
                        <?= $akt->Tittel ?>
                    </h1>
                    <form name="form_aktivitet" action="php/activity.php?action=edit&akti=<?= $id ?>" onsubmit="return valdierAktivitet()" method="post">
                        <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel" placeholder="Tittel.." value="<?= $akt->Tittel; ?>"><br/><br/>
                        <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20" cols="100" placeholder="Beskrivelse.."><?= $akt->Beskrivelse; ?></textarea><br/><br/>
                        <?php $dato = new DateTime($akt->Dato); ?>
                        <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato" value="<?= $dato->format('Y-m-d\TH:i:s'); ?>"><br><br>
                        <label for="pris">Pris</label> <input type="number" id="pris" name="pris" value="<?= $akt->Pris; ?>"><br/><br/>
                        <label for="bilde">Bilde URL</label> <input type="text" id="bilde" name="bilde" value="<?= $akt->Bilde; ?>"><br/><br/>

                        <!--Koordinater for GOOGLE MAPS KART-->
                        <input type="hidden" id="lengdegrad" name="lengdegrad" value="<?= $akt->Lengdegrad; ?>" />
                        <input type="hidden" id="breddegrad" name="breddegrad" value="<?= $akt->Breddegrad; ?>" />

                        <?php
                            if (erAdmin($brukernavn))
                                echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk"' . ($akt->Statisk === 1 ? 'checked="checked"' : '') . '><br/><br/>';
                            ?>

                            <div id="mapaktivitet"></div>
                            <!--Laste google maps-->
                            <script type='text/javascript'>
                                startMaps(<?=$akt->Breddegrad;?>, <?=$akt->Lengdegrad;?>, true);

                            </script>

                            <input class="button" type="submit" value="Registrer redigering" />
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
            if(erVerifisert($brukernavn))
            {
            ?>
                        <h1>Lag ny aktivitet</h1>
                        <form name="form_aktivitet"  action="php/activity.php?action=reg" onsubmit="return valdierAktivitet()"  method="post">
                            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel" placeholder="Tittel.."><br/><br/>
                            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="20" cols="100" placeholder="Beskrivelse.."></textarea><br/><br/>
                            <input type="hidden" id="apning" name="apning" value="">
                            <?php $dato = new DateTime(); ?>
                            <label for="dato">Dato</label> <input type="datetime-local" name="dato" id="dato" value="<?= $dato->format('Y-m-d\TH:i:s'); ?>"><br><br>
                            <label for="pris">Pris</label> <input type="number" id="pris" name="pris" value="0"><br/><br/>
                            <label for="bilde">Bilde URL</label> <input type="text" id="bilde" name="bilde"><br/><br/>

                            <!--Koordinater for GOOGLE MAPS KART-->
                            <input type="hidden" id="lengdegrad" name="lengdegrad" value="0" />
                            <input type="hidden" id="breddegrad" name="breddegrad" value="0" />

                            <?php
                if (erAdmin($brukernavn))
                    echo '<label for="statisk">Statisk</label> <input type="checkbox" id="statisk" name="statisk" value="1"><br/><br/>';
                ?>

                                <div id="mapaktivitet"></div>
                                <!--Laste google maps-->
                                <script type='text/javascript'>
                                    startMaps(59.922425, 10.751672, true);

                                </script>

                                <!--TAGS-->
                                <h3>Tags, skill med mellomrom</h3>
                                <input class="inputTag" type="text" id="tag" name="tag"><br>

                                <input class="button" type="submit" value="Registrer aktivitet" />
                        </form>

                        <?php
                
                }else
                {
                    echo "<h1>Verifiser emailadressen din for å opprette en ny aktivtet!</h1>";
                }
        } else {
            echo "<h1>Logg inn for å opprette en ny aktivitet!</h1>";
        }
    }
    ?>
</div>
