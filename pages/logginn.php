<div id="loggInnBoks">
	<?php
    
    // Statusmelding
    if(isset($_SESSION["status"]))
    {
        switch($_SESSION["status"])
        {
            case "loggedinn":
                break;
            case "loggedinn":
                break;
            case "loggedinn":
                break;
            case "loggedinn":
                break;
            case "loggedinn":
                break;
            case "loggedinn":
                break;
            case "loggedinn":
                break;
                
                
        }
    }
	 $brukernavn = loggetInnBruker();
	 if($brukernavn)
	 {
	    echo "Du er allerede logget inn som: " . $brukernavn;
	    echo "<img src=".hentBrukerBilde()." width='40px' height='40px'></img>";
        echo '<form action="php/user.php?action=out" method="post">
            <input type="submit" value="Logg ut" />
        </form>';
	 }
	 else
	 {?>
        <h3>Logg inn</h3>
	      <form action="php/user.php?action=in" method="post">
	           Brukernavn<br><input type="username" id="bruker" name="bruker"><br>
	           Passord<br><input type="password" id="passord" name="passord"><br>
	            <button type = "submit">Logg inn</button>
	       </form>
    
            <h3>Registrer ny bruker</h3>
            <form action="php/user.php?action=reg" method="post">
                Brukernavn<br><input type="username" id="bruker" name="bruker"><br>
                Email<br><input type="email" id="email" name="email"><br>
                Passord<br><input type="password" id="passord" name="passord"><br>
                <button type="submit">Registrer bruker</button>
            </form>
	<?php
     }
    ?>
</div>	