<?php
require_once __DIR__ . '/../database/tools/bruker.php';
session_start();

// Om action er valgt
if(isset($_GET["action"]))
{
    $action = $_GET["action"];
    
    // Logge inn
    if($action === "in")
    {
        if(isset($_POST["bruker"]) && isset($_POST["passord"]))
        {
            $bruker = $_POST["bruker"];
            $pass = $_POST["passord"];
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
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);