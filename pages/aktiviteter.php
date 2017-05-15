<?php
    $sideTall = 0;
    $sideTallBak = 0;
    $sideTallFrem = 0;
if(isset($_GET['p']))
    $sideTall = $_GET['p'];

if($sideTallBak - 1 >= 0)
    $sideTallBak = $sideTall - 1;
$sideTallFrem = $sideTall + 1;

        echo '<div class="center">';
        if(isset($_GET['tag']))
        {
            $tag = $_GET['tag'];
            
            echo "<h3>Aktiviteter fra ".$tag."</h3>";
            
            foreach(hentAktiviteterFraTag($tag, $sideTall) as $akt)
            {
                printAktivitetBoks($akt->Aktivitet);
            }
            
             echo '<br><a href="?side=aktiviteter&tag='.$tag.'&p='.$sideTallBak.'"><div class="navPil"><</div></a><div class="navPil">-</div>';
            echo '<a href="?side=aktiviteter&tag='.$tag.'&p='.$sideTallFrem.'"><div class="navPil">></div></a>';
        }else
        { 
            echo "<h3>Aktiviteter</h3>";
            foreach(hentAktiviteterFraSide($sideTall) as $akt)
            {
                printAktivitetBoks($akt->id);
            }
            
            echo '<br><a href="?side=aktiviteter&p='.$sideTallBak.'"><div class="navPil"><</div></a><div class="navPil">-</div>';
            echo '<a href="?side=aktiviteter&p='.$sideTallFrem.'"><div class="navPil">></div></a>';
        }
        echo "</div>";
?>