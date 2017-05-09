<div id="aktivitetBoks">
    
    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            if(eksistererBruker($id))
            {
                $bruker = hentBruker($id);
                echo "<h1>" . $bruker->Brukernavn . "</h1>";
                echo "<b>Email: " . $bruker->Email . "</b><br>";
                echo "<b>Admin: " . $bruker->Admin . "</b><br>";
                echo "<b>Registrert: " . $bruker->Registrert . "</b><br>";
                echo '<img src="'.hentBrukerBilde($id).'" height="100px width="100px"/>';
                
            }else
            {
                echo "<h1>Bruker med id " . $_GET['id'] . " eksisterer ikke!</h1>";
            }
        }else
        {
            $brukernavn = loggetInnBruker();
            if($brukernavn)
            {
                $bruker = hentBruker($brukernavn);
                echo "<h1>" . $bruker->Brukernavn . "</h1>";
                echo "<b>Email: " . $bruker->Email . "</b><br>";
                echo "<b>Admin: " . $bruker->Admin . "</b><br>";
                echo "<b>Registrert: " . $bruker->Registrert . "</b><br>";
                echo '<img src="'.hentBrukerBilde($brukernavn).'" height="100px width="100px"/>';
            }else
            {
                echo "<h1>Logg inn for å opprette en ny aktivitet!";
            }
        }
    ?>

</div>	