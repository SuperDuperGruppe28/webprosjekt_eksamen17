<?php
// vis feilmeildinger
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// PHP_verktoy
require_once __DIR__ . '/database/tools/bruker.php';
require_once __DIR__ . '/database/tools/aktivitet.php';
require_once __DIR__ . '/database/tools/kommentar.php';
require_once __DIR__ . '/database/tools/tag.php';

// Starte session
if (session_status() == PHP_SESSION_NONE) 
    session_start();

$GSide = "side";
$tittel = "main";
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
        <link rel="stylesheet" type="text/css" href="/../../css/main.css?v=<?=time();?>">
        
        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" rel="stylesheet">
        
        <!--Scripts-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        
        <title><?php echo $tittel?></title>
    </head>
    
    <body>
        
        <!-- HEADER -->
        <header><?php require 'pages/header.php'?></header>
        
        <!-- BODY -->
        <div id="bodyContainer">
        
        <?php
            // Henter angitt side
            $page = 'pages/'.$tittel.'.php';
            if(file_exists($page))
            {
                require $page;
            }else
            {
                require 'pages/main.php'; 
            }
        ?>
            
        </div>
        <!-- FOOTER -->
        <footer><?php require 'pages/footer.php'?></footer>
    </body>
</html>