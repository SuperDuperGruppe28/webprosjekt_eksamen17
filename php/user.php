<?php
require_once __DIR__ . '/../database/tools/bruker.php';
if (session_status() == PHP_SESSION_NONE) 
    session_start();

// Konstanter
$PBruker = "bruker";
$PPassord = "passord";
$PEmail = "email";

// Om action er valgt
if(isset($_GET["action"]))
{
    $action = $_GET["action"];
    
    // Logge inn
    if($action === "in")
    {
        if(isset($_POST[$PBruker]) && isset($_POST[$PPassord]))
        {
            $bruker = $_POST[$PBruker];
            $pass = $_POST[$PPassord];
            if(brukerLoggInn($bruker, $pass))
            {
                $_SESSION["user"] = $bruker;
                echo "logget inn bruker " . $bruker;
            }else
            {
                echo "Logginn feilet!";
            }
        }
    // Logge ut
    }else if($action === "out")
    {
        session_unset(); 
        session_destroy();
        echo "logout";
        
    // Registerer ny bruker
    }else if($action === "reg")
    {
       if(isset($_POST[$PBruker]) && isset($_POST[$PPassord]) && isset($_POST[$PEmail]))
        {
            $bruker = $_POST[$PBruker];
            $pass = $_POST[$PPassord];
            $email = $_POST[$PEmail];
            
            if(!eksistererBruker($bruker))
            {
                if(registrerBruker($bruker, $email, $pass, 0))
                {
                    sendVerifiseringsEmail($bruker);
                    echo $bruker . " har blitt registrert, sjekk din email for å verifisere konto!";
                }else
                {
                    echo "Noe gikk galt";
                }
                    
            }else
            {
                echo "Bruker eksisterer allerede!";
            }
        }
        echo "Registred";
    }
}

// Sender tilbake til forrige side
header('Location: ' . $_SERVER['HTTP_REFERER']);