<div id="headerContainer">
    <center>

        <nav>
            <ul>
                <li>
                    <a><img src="/img/logo.png" width="200px" Height="40px" style="vertical-align: middle"></a>
                </li>
                <li><a href="?side=main">Hjem</a></li>
                <li>
                    <a href="?side=aktiviteter">Aktiviteter <span class="caret"></span></a>
                    <div>
                        <ul>
                        <?php $aktiviteter = Aktivitet::All(); 
                        foreach($aktiviteter as $aktivitet) {
                            $deltagere = $aktivitet->deltagere()->get();
                            $deltar = false;
                            foreach($deltagere as $deltager)
                            {
                                //echo "<br>  "."Deltager: " . $deltager->Bruker;
                                if ($deltager->Bruker == loggetInnBruker()) {
                                    $deltar = true;
                                    break;
                                }
                            }
                            if($deltar)
                            {
                                echo '<li><a id="login" href="#">' . $aktivitet->Tittel . '</a></li>';
                            } else
                            {
                                echo '<li><a href="#">' . $aktivitet->Tittel . '</a></li>';
                            }
                            
                        }  
                        ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="?side=aktiviteter">Tags <span class="caret"></span></a>
                    <div>
                        <ul>
                            <?php                                 
                        foreach(hentAlleAktivitetTags() as $tag) 
                        {
                            echo '<li><a href="#">' . $tag->Tag . '</a></li>';
                        }?>
                        </ul>
                    </div>
                </li>
                <li><a href="?side=aktivitet">Lag aktivitet</a></li>
                <li><a href="?side=test">Søkefelt</a></li>
                <?php
            if(erBrukerLoggetInn())
            {
                echo '<li><a id="loginfo" href="?side=bruker">';
                echo "<img style='vertical-align: middle' src=".hentBrukerBilde()." width='40px' height='40px'></img>";
                echo ' '.loggetInnBruker();
                echo '</a></li>';
                
                echo '<li><a id="logout" href="/php/user.php?action=out">Logg ut</a></li>';
            }
            else
            {
                echo '<li><a id="login" href="?side=logginn">Logg inn</a></li>';
            }
        ?>
                    </li>
            </ul>
        </nav>
    </center>
</div>