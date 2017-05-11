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
                styles: [{
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#444444"
                    }]
                }, {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#f2f2f2"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 45
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#46bcec"
                    }, {
                        "visibility": "on"
                    }]
                }]
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


    <div id="kalender">

        <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;bgcolor=%23c0c0c0&amp;src=btcl0vgqt65veto83jbvdtgtvk%40group.calendar.google.com&amp;color=%23333333&amp;ctz=Europe%2FBrussels" style="border:solid 1px #777" width="200" height="150" frameborder="0" scrolling="no"></iframe>
    </div>