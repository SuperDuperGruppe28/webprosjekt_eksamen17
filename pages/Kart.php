<?php
?>


    <h2><b><center>Vulkan</b></h2></center>

    <div id="maps" class="center" style=""></div>

    <script type="text/javascript">
        var locations = [
    <?php
            $aktiviteter = hentAlleAktiviteter();

            $statisk_gratis = "/img/rod-pointer.png";
            $dynamisk_gratis = "/img/blaa-pointer.png";
            $statisk = "https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png";
            $dynamisk = "https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png";
        
            echo "['Fjerdingen', 0.0, 0.0 , 0 ,'/img/Skole-pointer.png'],";
            echo "['Vulkan', 0.0, 0.0 ,0,'/img/Skole-pointer.png'],";
            for($i = 0; $i < count($aktiviteter); $i++) {
                    $aktivitet = $aktiviteter[$i];
                    if(strtotime($aktivitet->Dato) <= time() && $aktivitet->Statisk != 1) continue; 
                    
                            
                                    $breddegrad = $aktivitet->Breddegrad;
                                    $lengdegrad = $aktivitet->Lengdegrad;
                                    $tittel = $aktivitet->Tittel;
                                    echo "['" . $tittel . "'," . $breddegrad . "," . $lengdegrad . "," . $i;
                
                                    $bGratis = ($aktivitet->Pris > 0);
                                    $bStatisk = $aktivitet->Statisk;
                                    if($bGratis && $bStatisk)
                                        echo ",'" . $statisk_gratis;
                                    else if($bGratis && !$bStatisk)
                                        echo ",'" . $dynamisk_gratis;
                                    else if(!$bGratis && $bStatisk)
                                        echo ",'" . $statisk;
                                    else if(!$bGratis && !$bStatisk)
                                        echo ",'" . $dynamisk;
                
                                    if($i==count($aktiviteter))
                                        echo "']";
                                    else
                                        echo "'],";
                    }
            ?>
      
    ];

        
        
        var map = new google.maps.Map(document.getElementById('maps'), {
            zoom: 16,
            center: new google.maps.LatLng(59.922425, 10.751672),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: locations[i][4]
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    </script>