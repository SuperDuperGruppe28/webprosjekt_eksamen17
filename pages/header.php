<div id="headerContainer">
    <center>

        <nav>
            <ul>
                <li>
                    <a href="?side=main"><img src="/img/logo.png" width="200px" Height="40px" style="vertical-align: middle"></a>
                </li>
                <li><a href="?side=main">Hjem</a></li>
                <li>
                    <a href="?side=aktiviteter">Aktiviteter<span class="caret"></span></a>
                    <div>
                        <ul>
                            <?php                                 
                        foreach(Tags::All() as $tag) 
                        {
                            echo '<li><a href="?side=aktiviteter&tag='.$tag->Tag.'">' . $tag->Tag . '<span class="caret"></span></a>';
                            echo '<div><ul>';
                            
                            $aktiviteter = TagsAktivitet::where("Tag", "=", $tag->Tag)->get();
                
                            foreach($aktiviteter as $aktivitet) {
                                $href = "?side=aktivitet&id=" . $aktivitet->Aktivitet;
                                $aktivitet = hentAktivitet($aktivitet->Aktivitet);
                                
                                $deltagere = $aktivitet->deltagere()->get();
                                $deltar = false;
                                foreach($deltagere as $deltager)
                                {
                                    if ($deltager->Bruker == loggetInnBruker()) {
                                        $deltar = true;
                                        break;
                                    }
                                }
                                
                                //echo '<li><a href="'.$href.'">' . $aktivitet->Tittel . '</li>';
                                $href = "?side=aktivitet&id=" . $aktivitet->id;
                                if($deltar)
                                {
                                    echo '<li><a id="delta" href="'. $href .'">' . $aktivitet->Tittel . '</a></li>';
                                } else
                                {
                                    echo '<li><a href="'. $href .'">' . $aktivitet->Tittel . '</a></li>';
                                }
                            }
                            
                            echo '</ul></div></li>';
                            
                        }?>
                        </ul>
                    </div>
                </li>
                <li><a href="?side=aktivitet">Lag aktivitet</a></li>
                <li>
                    <form  action="?side=sok" method="post" id="searchbox" style='vertical-align:middle'>
                        <input id="search" name="sok" type="text" placeholder="Søk her . . .">
                        <input id="submit" type="submit" value="Søk">
                    </form>
                </li>                
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
   
                    <form id="searchbox" style='vertical-align:middle'>
                        <input id="search" type="text" placeholder="Søk her . . .">
                        <input id="submit" type="submit" value="Søk">
                    </form>
               
    </center>
</div>