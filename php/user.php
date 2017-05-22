<?php
require_once __DIR__ . '/../database/tools/bruker.php';
if (session_status() == PHP_SESSION_NONE)
    session_start();

// Konstanter
$PBruker = "bruker";
$PPassord = "passord";
$PEmail = "email";

$Sstatus = "status";

// Om action er valgt
if (isset($_GET["action"])) {
    $action = $_GET["action"];

    // Logge inn
    if ($action === "in") {
        if (isset($_POST[$PBruker]) && isset($_POST[$PPassord])) {
            $bruker = $_POST[$PBruker];
            $pass = $_POST[$PPassord];
            if (brukerLoggInn($bruker, $pass)) {
                $_SESSION["user"] = $bruker;
                echo "logger inn " . $bruker . "..";
                $_SESSION[$Sstatus] = "loggedinn";
            } else {
                echo "Logginn feilet!";
                $_SESSION[$Sstatus] = "logginn_failed";
            }
        }
        // Logge ut
    } else if ($action === "out")
    {
        session_unset();
        session_destroy();
        echo "logger ut..";

        // Registerer ny bruker
    } else if ($action === "reg") {
        if (isset($_POST[$PBruker]) && isset($_POST[$PPassord]) && isset($_POST[$PEmail])) {
            $bruker = $_POST[$PBruker];
            $pass = $_POST[$PPassord];
            $email = $_POST[$PEmail];

            if(brukerDataValid($bruker, $email, $pass))
            {
                if (!eksistererBruker($bruker)) 
                {
                    if (registrerBruker($bruker, $email, $pass, 0)) 
                    {
                        sendVerifiseringsEmail($bruker);
                        echo $bruker . " har blitt registrert, sjekk din email for å verifisere konto!";
                        $_SESSION[$Sstatus] = "regged";
                    } else {
                        $_SESSION[$Sstatus] = "regged_failed";
                        echo "Noe gikk galt";
                    }

                } else {
                    $_SESSION[$Sstatus] = "regged_failed_exist";
                    echo "Bruker eksisterer allerede!";
                }
            }else
            {
                echo "Feil input";
                echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=logginn"/></head></html>';
            }
        }
    // Redigere brukeren
    } else if ($action === "edit")
    {
        $bruker = loggetInnBruker();
        if($bruker)
        {
            if (isset($_POST[$PEmail])) 
            {
                $email = $_POST[$PEmail];
                if(brukerEditValid($email))
                {
                    if(redigerBrukerEmail($bruker, $email))
                    {
                        settVerifisert($bruker, 0);
                        sendVerifiseringsEmail($bruker);
                    }
                }
            }
        }
    }
}

// Sender tilbake til forrige side
echo '<html><head><meta http-equiv="refresh" content="0;URL='.$WEBSIDEMAPPE.'?side=bruker"/></head></html>';

// Validerer inputdataen før spørring
function brukerDataValid($bruker, $email, $passord)
{
    if($bruker === "")
        return false;
    if($email === "")
        return false;
    if($passord === "")
        return false;
    
    if(strlen($bruker) > 30)
        return false;
    if(strlen($email) > 70)
        return false;
    if(strlen($passord) > 60)
        return false;
  
    return true;
}

// Validerer inputdataen før spørring
function brukerEditValid($email )
{
    if($email === "")
        return false;

    if(strlen($email) > 70)
        return false;

    return true;
}
