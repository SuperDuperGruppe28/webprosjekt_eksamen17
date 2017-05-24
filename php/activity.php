<?php
require_once __DIR__ . '/../database/tools/bruker.php';
require_once __DIR__ . '/../database/tools/aktivitet.php';
require_once __DIR__ . '/../database/tools/tag.php';

$bruker = loggetInnBruker();

// Konstanter
$MAX_TAGS = 5;

$PTittel = "tittel";
$PBeskrivelse = "beskrivelse";
$PDato = "dato";
$PPris = "pris";
$PStatisk = "statisk";
$PBilde = "bilde";
$PLengdegrad = "lengdegrad";
$PBreddegrad = "breddegrad";
$PDeltagelse = "deltagelse";

$PTag = "tag";

$GAction = "action";
$GAktivitet = "akti";

$action = "";
// Om bruker er logget inn
if ($bruker) {
    if (isset($_GET[$GAction]))
        $action = $_GET[$GAction];

    // Logge inn
    if ($action === "reg") {
        if (isset($_POST[$PTittel]) && isset($_POST[$PBeskrivelse]) && isset($_POST[$PDato]) && isset($_POST[$PPris]) && isset($_POST[$PBilde]) && isset($_POST[$PLengdegrad]) && isset($_POST[$PBreddegrad])) {
            $statisk = 0;
            if (isset($_POST[$PStatisk]))
                $statisk = 1;
            // Registerer ny aktivitet
            if(aktivitetDataValid($_POST[$PTittel], $_POST[$PBeskrivelse], $_POST[$PPris], $_POST[$PBilde]))
            {
                $id = skapAktivitet($bruker,
                $_POST[$PTittel],
                $_POST[$PBeskrivelse],
                $_POST[$PDato],
                $_POST[$PPris],
                $statisk,
                $_POST[$PBilde],
                $_POST[$PLengdegrad],
                $_POST[$PBreddegrad]);
                
                // Henter tagstrengen og splitter tagsene opp
                if (isset($_POST[$PTag]))
                {
                    $tagArray = explode( ' ', $_POST[$PTag] );
                    // Tags
                    for($i = 0; $i < count($tagArray); $i++)
                    {
                        if ($i >= $MAX_TAGS)
                            break;
                         if(tagDataValid($tagArray[$i]))
                            registrerAktivitetTag($id, $tagArray[$i]);
                    }
                }

                echo "Skapte aktivtetet <b>" . $_POST[$PTittel] . "</b>.";
                echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id='.$id.'"/></head></html>';
            }else
            {
                echo "Feil input data";
            }
            
        } else {
            echo "Mangler data";
        }
        // Redigere aktivitet
    } else if ($action === "edit") {
        if (isset($_GET[$GAktivitet])) {
            if ($bruker) {
                $aktivitetbruker = hentAktivitet($_GET[$GAktivitet])->Bruker;
                if ($bruker === $aktivitetbruker || erAdmin($bruker)) {
                    if (isset($_POST[$PTittel]) && isset($_POST[$PBeskrivelse]) && isset($_POST[$PDato]) && isset($_POST[$PPris]) && isset($_POST[$PBilde]) && isset($_POST[$PLengdegrad]) && isset($_POST[$PBreddegrad])) {
                        $statisk = 0;
                        if (isset($_POST[$PStatisk]))
                            $statisk = 1;
                        
                        if(aktivitetDataValid($_POST[$PTittel], $_POST[$PBeskrivelse], $_POST[$PPris], $_POST[$PBilde]))
                        {
                            // Registerer ny aktivitet
                            redigerAktivitet($_GET[$GAktivitet],
                                $_POST[$PTittel],
                                $_POST[$PBeskrivelse],
                                $_POST[$PDato],
                                $_POST[$PPris],
                                $statisk,
                                $_POST[$PBilde],
                                $_POST[$PLengdegrad],
                                $_POST[$PBreddegrad]);
                            echo "Redigerte aktivtetet <b>" . $_POST[$PTittel] . "</b>.";
                            // Sender tilbake til forrige side
                            echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id=' . $_GET[$GAktivitet] . '"/></head></html>';
                        }else
                        {
                             echo "Feil input  <b>" . $_POST[$PTittel] . "</b>.";
                            // Sender tilbake til forrige side
                            echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id=' . $_GET[$GAktivitet] . '"/></head></html>';
                        }

                    }
                }
            }
            
        } else {
            echo "Mangler data";
            echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=main"/></head></html>';

        }
    } else if ($action === "del") {
        if (isset($_GET[$GAktivitet]))
        {
            $akt = hentAktivitet($_GET[$GAktivitet]);
            if(erAdmin($bruker) || $brukernavn === $akt->Bruker)
            {
                 slettAktivitet($_GET[$GAktivitet]);
                echo "Slettet aktivitet!";
                // Sender tilbake til forrige side
                echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=main"/></head></html>';
            }else
            {
                echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id=' . $_GET[$GAktivitet] . '"/></head></html>';
            }
           
        }
    } else if ($action === "stem") {
        if (isset($_GET[$GAktivitet])) {
            if ($bruker) {
                if (!harStemtAktivitet($bruker, $_GET[$GAktivitet])) {
                    stemAktivitet($bruker, $_GET[$GAktivitet]);
                } else {
                    slettStemme($bruker, $_GET[$GAktivitet]);
                }
            }
        }
        // Sender tilbake til forrige side
        echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id=' . $_GET[$GAktivitet] . '"/></head></html>';
    } else if ($action === "delta") {
        if (isset($_GET[$GAktivitet]) && isset($_POST[$PDeltagelse])) {
            if ($bruker) {
                if (hentDeltagelse($bruker, $_GET[$GAktivitet]) !== -1) {
                    endreDeltagelse($bruker, $_GET[$GAktivitet], $_POST[$PDeltagelse]);
                } else {
                    deltaAktivitet($bruker, $_GET[$GAktivitet], $_POST[$PDeltagelse]);
                }
            }
        }
        // Sender tilbake til forrige side
        echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=aktivitet&id=' . $_GET[$GAktivitet] . '"/></head></html>';
    }

} else {
    echo "<h1>Må være logget inn!</h1>";
    echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=logginn"/></head></html>';
}

// Validerer inputdataen før spørring
function aktivitetDataValid($tittel, $beskrivelse, $pris, $bilde)
{
    if($tittel === "")
        return false;
    if($beskrivelse === "")
        return false;
    if($pris < 0)
        return false;
    if($bilde === "")
        return false;
    
    if(strlen($tittel) > 45)
        return false;
    if(strlen($beskrivelse) > 1024)
        return false;
    if(strlen($bilde) > 512)
        return false;
        
    return true;
}

// Validerer inputdataen før spørring
function tagDataValid($tag)
{
    if($tag === "")
        return false;
    if(strlen($tag) > 45)
        return false;
    
    return true;
}


// Sender tilbake til forrige side
