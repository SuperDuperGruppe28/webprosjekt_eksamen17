<?php
// PHP_verktoy
require_once __DIR__ . '/database/tools/bruker.php';

// Starte session
if (session_status() == PHP_SESSION_NONE) 
    session_start();

$GSide = "side";
$tittel = "Default";
if(isset($_GET[$GSide]))
    $tittel = $_GET[$GSide];
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- HEAD -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Veldig bra side">
        <meta name="author" content="Gruppe28">
    
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="/../../css/main.css">
        <title><?php echo $tittel?></title>
    </head>
    
    <body>
        <!-- HEADER -->
        <header><?php require 'pages/header.php'?></header>
        
        <!-- BODY -->
        <?php
            // Henter angitt side
            if(isset($_GET[$GSide]))
            {
                switch($_GET[$GSide])
                {
                    case "test":
                            require 'pages/forms.php';
                        break;
                    
                    default:
                            require 'pages/main.php';
                        break;
                }
            }else
            {
                require 'pages/main.php'; 
            }
        ?>
        
        <!-- FOOTER -->
        <footer><?php require 'pages/footer.php'?></footer>
    </body>
</html>