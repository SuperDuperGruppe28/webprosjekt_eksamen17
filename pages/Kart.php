<?php
?>


    <h2><b><center>Vulkan</b></h2></center>

    <div id="maps" class="center" style=""></div>

    <script type="text/javascript">
        var locations = [
    <?php
            $aktiviteter = hentAlleAktiviteter();

            $statisk_gratis = "img/statisk_gratis.png";
            $dynamisk_gratis = "img/dynamisk_gratis.png";
            $statisk = "img/statisk.png";
            $dynamisk = "img/dynamisk.png";
        
            echo "['Fjerdingen', 59.916207, 10.759697, 0, 'img/skole_pointer.png', 'img/fjerdingen.png', 0],";
            echo "['Vulkan', 59.923393, 10.752508, 0, 'img/skole_pointer.png', 'img/vulkan.png', 0],";
            echo "['Campus Brenneriveien', 59.920460, 10.752508, 0, 'img/skole_pointer.png', 'img/brenneriveien.png', 0],";
            for($i = 0; $i < count($aktiviteter); $i++) {
                    $aktivitet = $aktiviteter[$i];
                    if(strtotime($aktivitet->Dato) <= time() && $aktivitet->Statisk != 1) continue; 
                    
                            
                                    $breddegrad = $aktivitet->Breddegrad;
                                    $lengdegrad = $aktivitet->Lengdegrad;
                                    $tittel = $aktivitet->Tittel;
                                    $id = $aktivitet->id;
                                    echo "['" . $tittel . "'," . $breddegrad . "," . $lengdegrad . "," . $id;
                
                                    $bGratis = ($aktivitet->Pris <= 0);
                                    $bStatisk = $aktivitet->Statisk;
                                    if($bGratis && $bStatisk)
                                        echo ",'" . $statisk_gratis;
                                    else if($bGratis && !$bStatisk)
                                        echo ",'" . $dynamisk_gratis;
                                    else if(!$bGratis && $bStatisk)
                                        echo ",'" . $statisk;
                                    else if(!$bGratis && !$bStatisk)
                                        echo ",'" . $dynamisk;
                                    echo "'";
                
                                    $bilde = $aktivitet->Bilde;
                                    echo ",'" . $bilde . "'";
                
                                    $pris = $aktivitet->Pris;
                                    echo "," . $pris;
                
                                    if($i==count($aktiviteter)-1)
                                        echo "]";
                                    else
                                        echo "],";
                    }
            ?>

    ];



        var map = new google.maps.Map(document.getElementById('maps'), {
            zoom: 15,
            center: new google.maps.LatLng(59.920188, 10.754633),
            mapTypeId: google.maps.MapTypeId.ROADMAP
            
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: locations[i][4],
                
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    var content = "";

                    if (locations[i][3] != 0)
                        content += '<img style="width:150px;height:150px" src="' + locations[i][5] + '"><br>';

                    content += '<a class="center" href="?side=aktivitet&id=' + locations[i][3] + '">' + locations[i][0] + '</a>';

                    if (locations[i][6] > 0)
                        content += '<div id="pris">Pris: ' + locations[i][6].toString() + "kr</div>";
                    
                    infowindow.setContent(
                        content
                    );

                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    </script>