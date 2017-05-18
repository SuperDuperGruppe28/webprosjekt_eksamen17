<div id="brukerBoks">

    <?php
    $Gid = "id";
    $GAction = "action";
    if(!isset($_GET[$GAction]))
    {
        if(isset($_GET[$Gid]))
        {
            $id = $_GET[$Gid];
            if(eksistererBruker($id))
            {
                $bruker = hentBruker($id);
                $deltar = hentBrukerDeltagelser($id, 1);
                $deltarKanskje = hentBrukerDeltagelser($id, 2);
                echo "<h1>" . tryggPrint($bruker->Brukernavn) . "</h1>";
                echo "<b>Email: " . tryggPrint($bruker->Email) . "</b><br>";

                if($bruker->Admin > 0)
                    echo "<b class='adminSkrift'>Admin</b><br>";
                echo "<b>Registrert: " . tryggPrint($bruker->Registrert) . "</b><br>";
                echo '<img src="'.tryggPrint(hentBrukerBildeEx($id)).'" height="100px width="100px"/><br>';

                echo "<b>Deltar i:</b><br>";
                foreach($deltar as $d)
                {
                    printAktivitetBoks($d->Aktivitet);
                }

                echo "<br><b>Deltar kanskje i:</b><br>";
                foreach($deltarKanskje as $dK)
                {
                    printAktivitetBoks($dK->Aktivitet);
                }

            }else
            {
                echo "<h1>Bruker med id " . $_GET[$Gid] . " eksisterer ikke!</h1>";
            }
        }else
        {
            $brukernavn = loggetInnBruker();
            $deltar = hentBrukerDeltagelser($brukernavn, 1);
            $deltarKanskje = hentBrukerDeltagelser($brukernavn, 2);
            if($brukernavn)
            {
                $bruker = hentBruker($brukernavn);
                echo "<h1>" . tryggPrint($bruker->Brukernavn) . "</h1>";
                echo "<b>Email: " . tryggPrint($bruker->Email) . "</b><br>";

                if($bruker->Admin > 0)
                    echo "<b class='adminSkrift'>Admin</b><br>";
                echo "<b>Registrert: " . tryggPrint($bruker->Registrert) . "</b><br>";
                echo '<img src="'.tryggPrint(hentBrukerBildeEx($brukernavn)).'" height="100px" width="100px"/><br>';

                if(count($deltar) != 0) {
                    echo "<b>Deltar i:</b><br>";
                    foreach($deltar as $d)
                    {
                        printAktivitetBoks($d->Aktivitet);
                    }
                } else {
                    echo "Deltar ikke i noen aktiviteter.";
                }

                if(count($deltarKanskje) != 0) {
                    echo "<br><b>Deltar kanskje i:</b><br>";
                    foreach($deltarKanskje as $dK)
                    {
                        printAktivitetBoks($dK->Aktivitet);
                    }
                }

            }else
            {
                echo "<h1>Logg inn for å se profilen din!";
            }
        }
    }
    else
    {
        if($_GET[$GAction] === "edit")
        {
            $brukernavn = loggetInnBruker();
           
            if($brukernavn)
            {
                $bruker = hentBruker($brukernavn);
            ?>
                <h1>Rediger <?=$brukernavn?></h1>
                <form action="php/user.php?action=reg" method="post">
                    Brukernavn<br><input type="username" id="bruker" name="bruker"><br>
                    Email<br><input type="email" id="email" name="email"><br>
                    Passord<br><input type="password" id="passord" name="passord"><br>
                    <input class="button" type="submit" value="Registrer bruker"/>
                </form>
            <?php
            }else
            {
                echo "Logg inn for å redigere bruker..";
            }
        }
    }
        
    ?>

</div>	