<div id="headerContainer">
    <center>
      
    <nav>
    <ul>
        <li><a href="?side=Home">Hjem</a></li>
        <li>
            <a href="?side=Activities">Aktiviteter <span class="caret"></span></a>
            <div>
                <ul>
                    <li>
                        <a href="?side=Activities">Ting <span class="caret"></span></a>
                        <div>
                            <ul>
                                
                                <li><a href="#">Arrangementer</a></li>
                                <li><a href="#">Butikker</a></li>
                                <li><a href="#">Restauranter</a></li>
                                <li><a href="#">Fysisk aktivitet</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="?side=test">Tang</a></li>
                    <?php 
                                
foreach(hentKommentarer(3) as $kom) 
{
    echo '<li><a href="#">' . $kom->Bruker . ": " . $kom->Tekst . '</a></li>';
}                               ?>
                </ul>
            </div>
        </li>
        <li><a href="?side=test">Aktuelt</a></li>
        <li><a href="?side=test">Om Vulkanelva</a>
        <li><a href="?side=bruker">Min side</a></li>
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