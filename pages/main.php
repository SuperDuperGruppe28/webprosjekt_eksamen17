<?php
// PHP_verktoy
require_once __DIR__ . '/../database/tools/bruker.php';
    $filename = pathinfo(__FILE__, PATHINFO_FILENAME);

    // Starte session
    if (session_status() == PHP_SESSION_NONE) 
        session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- HEAD -->
        <?php require 'shared/head.php'?>
        <title><?php echo $filename?></title>
    </head>
    
    <body>
        <!-- HEADER -->
        <header><?php require 'shared/header.php'?></header>
        <!-- BODY -->
        <?php require $filename.'/body.php'?>
        <!-- FOOTER -->
        <footer><?php require 'shared/footer.php'?></footer>
    </body>
</html>