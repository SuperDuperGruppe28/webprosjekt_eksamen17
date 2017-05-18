<div id="mainBoks">
    <h1>Vulkanelva</h1>
   <b>Hallo og velkommen til Vulkanelva, her vil du finne alt av aktiviteter og ting en kan bedrive tidne med i næromrodet til Campus Vulkan!</b>
</div>

<?php
echo '<div class="center">';
    echo "<h1>Nyeste aktiviteter</h1>";
      foreach (hentNyesteAktiviteter(5) as $akt)
      {
            printAktivitetBoksFraArray($akt);
      }

    echo "<h1>Dine anbefalte aktiviteter</h1>";
    echo "Kommer snart..kom tilbake senere!";
echo '</div>';
?>