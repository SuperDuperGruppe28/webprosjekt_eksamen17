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
                                
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
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
        <li><a href="?side=test">Om Oss</a></li>
        <li><a href="?side=test">Test</a></li>
    </ul>
</nav>
    </center>
</div>