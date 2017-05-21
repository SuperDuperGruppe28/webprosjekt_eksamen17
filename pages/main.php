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
?>

<div id="mainBoks">
    <h1>Vulkanelva</h1>
    <p>Hallo og velkommen til Vulkanelva, her vil du finne alt av aktiviteter og ting en kan bedrive tiden med i næromrodet til Campus Vulkan!</p>

    <h3>Her finner du oss!</h3>
    <div id="map"></div>
</div>