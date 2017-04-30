<?php $filename=pathinfo(__FILE__, PATHINFO_FILENAME);?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Veldig bra side">
        <meta name="author" content="Gruppe28">
        <title><?php echo $filename?></title>
    </head>
    <body>
        <header><?php require $filename.'/header.php'?></header>
        <a href="/pages/test.php">test side</a>
        <footer><?php require $filename.'/footer.php'?></footer>
    </body>
</html>