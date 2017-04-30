<?php session_start();
$filename=pathinfo(__FILE__, PATHINFO_FILENAME);?>
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
        
        <form action="php/user.php?action=in" method="post">
            <label for="username">Brukernavn</label> <input type="username" id="bruker" name="bruker"><br /><br />
            <label for="password">Passord:</label> <input type="password" id="passord" name="passord"><br /><br />
            <button type = "submit">Logg inn</button>
        </form>
        
        <form action="php/user.php?action=out" method="post">
            <input type="submit" value="Logg ut" />
        </form>
        
        <form action="php/user.php?action=reg" method="post">
            <br><br><br>
            <form action="php/user.php?action=reg" method="post">
            <label for="username">Brukernavn</label> <input type="username" id="bruker" name="bruker"><br /><br />
            <label for="password">Passord:</label> <input type="password" id="passord" name="passord"><br /><br />
            <label for="password">Email:</label> <input type="email" id="email" name="email"><br /><br />
            <button type = "submit">Registrer bruker</button>
        </form>

        <footer><?php require $filename.'/footer.php'?></footer>
    </body>
</html>