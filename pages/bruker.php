<div id="brukerBoks">

    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
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
                echo "<h1>Bruker med id " . $_GET['id'] . " eksisterer ikke!</h1>";
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
    ?>

</div>	