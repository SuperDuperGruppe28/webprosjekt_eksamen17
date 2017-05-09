<?php
// PHP_verktoy
require_once __DIR__ . '/database/tools/bruker.php';
require_once __DIR__ . '/database/tools/aktivitet.php';
require_once __DIR__ . '/database/tools/kommentar.php';
require_once __DIR__ . '/database/tools/tag.php';

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
        <link rel="stylesheet" type="text/css" href="/../../css/main.css?v=<?=time();?>">
        <link rel="stylesocial" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <a href="#" class="social social-facebook"</a>
        <a href="#" class="social social-twitter"</a>
        
        <title><?php echo $tittel?></title>
    </head>
    
    <body>
        <!-- HEADER -->
        <header><?php require 'pages/header.php'?></header>
        
        <!-- BODY -->
        <div id="bodyContainer">
        <?php
            // Henter angitt side
            $page = 'pages/'.$_GET[$GSide].'.php';
            if(file_exists($page))
            {
                require $page;
            }else
            {
                require 'pages/main.php'; 
            }
        ?>
        </div>
        
        <!-- GOOGLE MAP -->
        <div id="map"></div>
        
        <!-- FOOTER -->
        <footer><?php require 'pages/footer.php'?></footer>
    </body>
</html>