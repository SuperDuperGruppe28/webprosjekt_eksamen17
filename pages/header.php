<?php
require_once __DIR__ . '/../database/tools/bruker.php';
require_once __DIR__ . '/../database/tools/kommentar.php';
?>

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
        <li><a href="?side=test">Min side</a></li>
        <li><a href="?side=test">Søkefelt</a></li>
                    
        </li>
    </ul>
</nav>
    </center>
</div>