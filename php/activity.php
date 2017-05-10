<?php
require_once __DIR__ . '/../database/tools/bruker.php';
require_once __DIR__ . '/../database/tools/aktivitet.php';
require_once __DIR__ . '/../database/tools/tag.php';

$bruker = loggetInnBruker();

// Konstanter
$PTittel = "tittel";
$PBeskrivelse = "beskrivelse";
$PApning = "apning";
$PDato = "dato";
$PPris = "pris";
$PStatisk = "statisk";
$PBilde = "bilde";
$PLengdegrad = "lengdegrad";
$PBreddegrad = "breddegrad";

$PTag1 = "tag_1";
$PTag2 = "tag_2";
$PTag3 = "tag_3";
$PTagVekt1 = "tag_vekt1";
$PTagVekt2 = "tag_vekt2";
$PTagVekt3 = "tag_vekt3";

$GAction = "action";
$GAktivitet = "akti";

$action = "";
// Om bruker er logget inn
if($bruker)
{
    if(isset($_GET[$GAction]))
        $action = $_GET[$GAction];
    
    // Logge inn
    if($action === "reg")
    {
        if(isset($_POST[$PTittel]) && isset($_POST[$PBeskrivelse]) && isset($_POST[$PApning]) && isset($_POST[$PDato]) && isset($_POST[$PPris]) && isset($_POST[$PStatisk]) && isset($_POST[$PBilde]) && isset($_POST[$PLengdegrad]) && isset($_POST[$PBreddegrad]))
        {
            // Registerer ny aktivitet
           $id = skapAktivitet($bruker,
                          $_POST[$PTittel],
                          $_POST[$PBeskrivelse],
                          $_POST[$PApning],
                          $_POST[$PDato],
                          $_POST[$PPris],
                          $_POST[$PStatisk],
                          $_POST[$PBilde],
                          $_POST[$PLengdegrad],
                          $_POST[$PBreddegrad]);
            
            if(isset($_POST[$PTag1]) && isset($_POST[$PTag2]) && isset($_POST[$PTag3]) && isset($_POST[$PTagVekt1]) && isset($_POST[$PTagVekt2]) && isset($_POST[$PTagVekt3]))
            {
                // Tags
                registrerAktivitetTag($id, $_POST[$PTag1], $_POST[$PTagVekt1]);
                registrerAktivitetTag($id, $_POST[$PTag2], $_POST[$PTagVekt2]);
                registrerAktivitetTag($id, $_POST[$PTag3], $_POST[$PTagVekt3]);
            }
            echo "Skapte aktivtetet <b>" . $_POST[$PTittel] . "</b>.";
            header('Location: ' . $_SERVER['HTTP_REFERER'] . "&id=".$id);
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
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }else if($action === "stem")
    {
        if(isset($_GET[$GAktivitet]))
        {
            if($bruker)
            {
                if(!harStemtAktivitet($bruker, $_GET[$GAktivitet]))
                {
                    stemAktivitet($bruker, $_GET[$GAktivitet]);
                }else
                {
                    slettStemme($bruker, $_GET[$GAktivitet]);
                }
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  
}else
{
    echo "<h1>Må være logget inn!</h1>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// Sender tilbake til forrige side
