<?php
?>


    

    <div id="maps" class="center" style="width: 500px; height: 400px;"></div>

    <script type="text/javascript">
        var locations = [
    <?php
            $aktiviteter = hentAlleAktiviteter();

          
            for($i = 0; $i < count($aktiviteter); $i++) {
                    $aktivitet = $aktiviteter[$i];
                            
                                    $breddegrad = $aktivitet->Breddegrad;
                                    $lengdegrad = $aktivitet->Lengdegrad;
                                    $tittel = $aktivitet->Tittel;
                                    echo "['" . $tittel . "'," . $breddegrad . "," . $lengdegrad . "," . $i; 
                                    if($i==count($aktiviteter))
                                        echo "]";
                                    else
                                        echo "],";
                    }
            ?>
      
    ];

        var map = new google.maps.Map(document.getElementById('maps'), {
            zoom: 14,
            center: new google.maps.LatLng(59.922425, 10.751672),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    </script>