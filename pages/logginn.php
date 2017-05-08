<div id="loggInnBoks">
	<?php
	 $brukernavn = loggetInnBruker();
	 if($brukernavn)
	 {
	    echo "Du er allerede logget inn som: " . $brukernavn;
	    echo "<img src=".hentBrukerBilde()." width='40px' height='40px'></img>";
	 }
	 else
	 {?>
	      <form action="php/user.php?action=in" method="post">
	            <label for="username">Brukernavn</label> <input type="username" id="bruker" name="bruker"><	br /><br />
	            <label for="password">Passord:</label> <input type="password" id="passord" name="passord"><	br /><br />
	            <button type = "submit">Logg inn</button>
	        </form>
	<?php
     }
    ?>
</div>	