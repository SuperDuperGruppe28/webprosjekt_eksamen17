<?php

// Frem og tilbakeknapper
$sideTall = 0;
$sideTallBak = 0;
$sideTallFrem = 0;
if (isset($_GET['p']))
    $sideTall = $_GET['p'];

if ($sideTall - 1 > 0)
    $sideTallBak = $sideTall - 1;
$sideTallFrem = $sideTall + 1;

echo '<div id="aktiviteterContainer">';
echo '<div class="center">';
if (isset($_GET['tag'])) {
    $tag = $_GET['tag'];

    echo "<h3>Aktiviteter fra " . $tag . "</h3>";

    foreach (hentAktiviteterFraTag($tag, $sideTall) as $akt) {
        printAktivitetBoks($akt->Aktivitet);
    }
    // Loggføre besøk av tag
    $brukernavn = loggetInnBruker();
    if ($brukernavn)
    {
        registrerBrukerBesok($brukernavn, $tag);
    }
    echo '<br><a href="?side=aktiviteter&tag=' . $tag . '&p=' . $sideTallBak . '"><div class="navPil"><</div></a><div class="navPil">-</div>';
    echo '<a href="?side=aktiviteter&tag=' . $tag . '&p=' . $sideTallFrem . '"><div class="navPil">></div></a>';
} else {
    echo "<h3>Aktiviteter</h3>";
    foreach (hentAktiviteterFraSide($sideTall) as $akt) {
        printAktivitetBoks($akt->id);
    }

    echo '<br><a href="?side=aktiviteter&p=' . $sideTallBak . '"><div class="navPil"><</div></a><div class="navPil">-</div>';
    echo '<a href="?side=aktiviteter&p=' . $sideTallFrem . '"><div class="navPil">></div></a>';
}
echo "</div>";
echo "</div>";

// Boks med tags
echo '<div id="tagsContainer">';
echo '<div class="center">';
echo '<h1>Tags</h1>';
foreach (hentAlleTags() as $tag) {
    echo '<a class="tagLink" href="?side=aktiviteter&tag=' . $tag->Tag . '">' . $tag->Tag . '</a><br>';
}
echo "</div>";
echo "</div>";

?>