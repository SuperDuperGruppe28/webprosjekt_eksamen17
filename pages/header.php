<div id="headerContainer">
    <div class="center">
        <nav>
            <ul>

                <a href="https://www.westerdals.no/" target="_blank"><img src="img/westerdals.png" width="70px"
                                                                          height="70px" style="vertical-align: middle"></a>

                <a href="?side=main"><img src="img/logo.png" width="200px" Height="40px"
                                          style="vertical-align: middle"></a>

                <li><a href="?side=main">Hjem</a></li>
                <li>
                    <a href="?side=aktiviteter">Aktiviteter<span class="caret"></span></a>
                    <div>
                        <ul>
                            <?php

                            $tags = Tags::all();
                            $tags_count = $tags->count();
                            $limit = 10;

                            $tags_limit = min($tags_count, $limit);

                            for ($i = 0; $i < $tags_limit; $i++) //foreach(Tags::All() as $tag)
                            {
                                $tag = $tags[$i];
                                echo '<li><a href="?side=aktiviteter&tag=' . $tag->Tag . '">' . $tag->Tag . '<span class="caret"></span></a>';
                                echo '<div><ul>';

                                $aktiviteter = TagsAktivitet::where("Tag", "=", $tag->Tag)->get();

                                foreach ($aktiviteter as $aktivitet) {
                                    $href = "?side=aktivitet&id=" . $aktivitet->Aktivitet;
                                    $aktivitet = hentAktivitet($aktivitet->Aktivitet);

                                    $deltagere = $aktivitet->deltagere()->get();
                                    $deltar = false;
                                    foreach ($deltagere as $deltager) {
                                        if ($deltager->Bruker == loggetInnBruker()) {
                                            $deltar = true;
                                            break;
                                        }
                                    }

                                    //echo '<li><a href="'.$href.'">' . $aktivitet->Tittel . '</li>';
                                    $href = "?side=aktivitet&id=" . $aktivitet->id;
                                    if ($deltar) {
                                        echo '<li><a id="delta" href="' . $href . '">' . $aktivitet->Tittel . '</a></li>';
                                    } else {
                                        echo '<li><a href="' . $href . '">' . $aktivitet->Tittel . '</a></li>';
                                    }
                                }

                                echo '</ul></div></li>';

                            }
                            // vis alle aktiviteter knapp hvis det er flere enn $limit
                            if ($tags_count > $limit) {
                                echo '<li><a href="?side=aktiviteter" class="cursive">vis alle</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <li><a href="?side=aktivitet">Lag aktivitet</a></li>

                <?php
                if (erBrukerLoggetInn()) {
                    echo '<li><a id="loginfo" href="?side=bruker">';
                    echo "<img style='vertical-align: middle' src=" . hentBrukerBilde() . " width='40px' height='40px'></img>";
                    echo ' ' . loggetInnBruker();
                    echo '</a></li>';

                    echo '<li><a id="logout" href="php/user.php?action=out">Logg ut</a></li>';
                } else {
                    echo '<li><a id="login" href="?side=logginn">Logg inn</a></li>';
                }
                ?>
               
            </ul>
        </nav>


        <form action="?side=sok" method="post" id="searchbox" style='vertical-align:middle'>
            <input id="search" name="sok" type="text" placeholder="Søk her . . .">
            <input id="submit" type="submit" value="Søk">
        </form>
    </div>
</div>