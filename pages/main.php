<?php

echo "<h3>Vulkanelva!(main body)</h3>";
 $brukernavn = loggetInnBruker();
 if($brukernavn)
 {
    echo "Logget inn som: " . $brukernavn;
    echo "<img src=".hentBrukerBilde()." width='40px' height='40px'></img>";
 }
 else
    echo "Ikke logget inn";
?>

<h3>Vulkanelva er området fra Kubaparken og ned til Westerdals ACT i Chr. Kroghs gate 32.
bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla bla bla bla blabla bla bla bla bla bla bla blabla bla bla bla bla bla bla blabla bla bla bla bla bla bla blabla bla bla bla bla bla bla blabla bla bla bla bla bla bla bla
</h3>

<div id="map"></div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        
        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', init);
        
            function init() {
                    var mapOptions = {
                    zoom: 16,

                    center: new google.maps.LatLng(59.922425, 10.751672), // Vulkan, Oslo
                    styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
                };
                var mapElement = document.getElementById('map');
                var map = new google.maps.Map(mapElement, mapOptions);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(59.922425, 10.751672),
                    map: map,
                    title: 'Vulkan'
                });
            }
        </script>