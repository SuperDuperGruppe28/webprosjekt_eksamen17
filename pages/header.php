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
                        <?php 
                            $aktiviteter = Aktivitet::All(); 
                            foreach($aktiviteter as $aktivitet) {
                                $deltagere = $aktivitet->deltagere()->get();
                                $deltar = false;
                                foreach($deltagere as $deltager)
                                {
                                    if ($deltager->Bruker == loggetInnBruker()) {
                                        $deltar = true;
                                        break;
                                    }
                                }
                                $href = "?side=aktivitet&id=" . $aktivitet->id;
                                if($deltar)
                                {
                                    echo '<li><a id="login" href="'. $href .'">' . $aktivitet->Tittel . '</a></li>';
                                } else
                                {
                                    echo '<li><a href="'. $href .'">' . $aktivitet->Tittel . '</a></li>';
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
                        foreach(Tags::All() as $tag) 
                        {
                            echo '<li><a href="#">' . $tag->Tag . '<span class="caret"></span></a>';
                            echo '<div><ul>';
                            
                            $aktiviteter = TagsAktivitet::where("Tag", "=", $tag->Tag)->get();
                            //echo '<pre>';
                           // print_r($aktiviteter);
                            foreach($aktiviteter as $aktivitet) {
                                echo '<li><a href="#">' . hentAktivitet($aktivitet->Aktivitet)->Tittel . '</li>';
                            }
                            
                            echo '</ul></div></li>';
                            
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