<div id="headerContainer">
    <center>
      
    <nav>
    <ul>
        <li><a href="?side=main">Hjem</a></li>
        <li>
            <a href="?side=aktiviteter">Aktiviteter <span class="caret"></span></a>
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