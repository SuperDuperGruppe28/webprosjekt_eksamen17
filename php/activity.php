<?php
require_once __DIR__ . '/../database/tools/bruker.php';
require_once __DIR__ . '/../database/tools/aktivitet.php';


$bruker = loggetInnBruker();

// Konstanter
$PTittel = "tittel";
$PBeskrivelse = "beskrivelse";
$PApning = "apning";
$PPris = "pris";
$PStatisk = "statisk";
$PBilde = "bilde";
$PLengdegrad = "lengdegrad";
$PBreddegrad = "breddegrad";

$GAction = "action";
$GAktivitet = "akti";

// Om bruker er logget inn
if($bruker)
{
    $action = $_GET[$GAction];
    
    // Logge inn
    if($action === "reg")
    {
        if(isset($_POST[$PTittel]) && isset($_POST[$PBeskrivelse]) && isset($_POST[$PApning]) && isset($_POST[$PPris]) && isset($_POST[$PStatisk]) && isset($_POST[$PBilde]) && isset($_POST[$PLengdegrad]) && isset($_POST[$PBreddegrad]))
        {
            // Registerer ny aktivitet
            skapAktivitet($bruker,
                          $_POST[$PTittel],
                          $_POST[$PBeskrivelse],
                          $_POST[$PApning],
                          $_POST[$PPris],
                          $_POST[$PStatisk],
                          $_POST[$PBilde],
                          $_POST[$PLengdegrad],
                          $_POST[$PBreddegrad]);
            echo "Skapte aktivtetet <b>" . $_POST[$PTittel] . "</b>.";
        }else
        {
            echo "Mangler data";
        }
    }else if($action === "del")
    {
        if(isset($_GET[$GAktivitet]))
        {
            slettAktivitet($_GET[$GAktivitet]);
            echo "Slettet aktivitet!";
        }
    }
  
}else
{
    echo "<h1>Må være logget inn!</h1>";
}