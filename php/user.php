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
        if(isset($_GET["bruker"]) && isset($_GET["passord"]))
        {
            $bruker = $_GET["bruker"];
            $pass = $_GET["passord"];
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