<?php 
require_once __DIR__ . '/../database/tools/bruker.php';

if (session_status() == PHP_SESSION_NONE) 
    session_start();
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);
?>
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
            
        <h1>Lag ny aktivitet</h1>
        <form action="php/activity.php?action=reg" method="post">
            <label for="tittel">Tittel</label> <input type="text" id="tittel" name="tittel"><br/><br/>
            <label for="beskrivelse">Beskrivelse</label> <textarea id="beskrivelse" name="beskrivelse" rows="10" cols="10"></textarea><br/><br/>
            <label for="apning">Åpning</label> <input type="text" id="apning" name="apning"><br/><br/>
            <label for="pris">Pris</label> <input type="number" id="pris" name="pris"><br/><br/>
            <label for="bilde">Bilde</label> <input type="text" id="bilde" name="bilde"><br/><br/>
            <input type = "hidden" id = "lengdegrad" name="lengdegrad" value = "0" />
            <input type = "hidden" id = "breddegrad" name="breddegrad" value = "0" />
            
            <?php
                if(isset($_SESSION["user"]))
                {
                    if(erAdmin($_SESSION["user"]))
                        echo '<label for="statisk">Statisk</label> <input type="number" id="statisk" name="statisk"><br/><br/>';    
                }
            ?>
            <button type = "submit">Registrer aktivitet</button>
        </form>
            
        <h1>Post kommentar</h1>
        <form action="php/comment.php?action=post" method="post">
            <label for="tekst">Tekst</label> <textarea id="tekst" name="tekst" rows="10" cols="10"></textarea><br/><br/>
            <input type="hidden" id="aktivitet" name="aktivitet" value="3" />            
            <button type = "submit">post kommentar</button>
        </form>
        
        <h1>Rediger kommentar</h1>
        <form action="php/comment.php?action=edit" method="post">
            <label for="tekst">Tekst</label> <textarea id="tekst" name="tekst" rows="10" cols="10"></textarea><br/><br/>
            <input type="hidden" id="kommentar" name="kommentar" value="1" />            
            <button type = "submit">Rediger kommentar</button>
        </form>

            
             <h1>Slett kommentar</h1>
        <form action="php/comment.php?action=del" method="post">

            <input type="hidden" id="kommentar" name="kommentar" value="1" />            
            <button type = "submit">post kommentar</button>
        </form>



        <footer><?php require $filename.'/footer.php'?></footer>
    </body>
</html>