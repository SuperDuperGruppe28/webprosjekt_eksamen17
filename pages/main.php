<?php
echo '<div class="center">';
    $anbefalte = hentAnbefalteAktiviteter(5);
    if($anbefalte !== null)
    {
        echo "<h1>Dine anbefalte aktiviteter</h1>";
        foreach ($anbefalte as $akt)
        {
            printAktivitetBoks($akt);
        }
    }    

    echo "<h1>Nyeste aktiviteter</h1>";
      foreach (hentNyesteAktiviteter(5) as $akt)
      {
            printAktivitetBoksFraArray($akt);
      }
echo '</div>';