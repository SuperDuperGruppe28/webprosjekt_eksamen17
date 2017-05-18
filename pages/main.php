<div id="mainBoks">
    <h1>Vulkanelva</h1>
   <p>Hallo og velkommen til Vulkanelva, her vil du finne alt av aktiviteter og ting en kan bedrive tidne med i næromrodet til Campus Vulkan!</p>
    
    <h3>Her finner du oss!</h3>
    <div id="map"></div>
 
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
 
 <script type="text/javascript">
     google.maps.event.addDomListener(window, 'load', init);
 
     function init() {
         var mapOptions = {
             zoom: 14,
 
             center: new google.maps.LatLng(59.922425, 10.751672), // Vulkan, Oslo
             styles: [{
                 "featureType": "administrative",
                 "elementType": "labels.text.fill",
                 "stylers": [{"color": "#444444"}]
             }, {
                 "featureType": "landscape",
                 "elementType": "all",
                 "stylers": [{"color": "#f2f2f2"}]
             }, {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}]}, {
                 "featureType": "road",
                 "elementType": "all",
                 "stylers": [{"saturation": -100}, {"lightness": 45}]
             }, {
                 "featureType": "road.highway",
                 "elementType": "all",
                 "stylers": [{"visibility": "simplified"}]
             }, {
                 "featureType": "road.arterial",
                 "elementType": "labels.icon",
                 "stylers": [{"visibility": "off"}]
             }, {
                 "featureType": "transit",
                 "elementType": "all",
                 "stylers": [{"visibility": "off"}]
             }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]}]
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
</div>

<?php
echo '<div class="center">';
    echo "<h1>Nyeste aktiviteter</h1>";
      foreach (hentNyesteAktiviteter(5) as $akt)
      {
            printAktivitetBoksFraArray($akt);
      }

    echo "<h1>Dine anbefalte aktiviteter</h1>";
    echo "Kommer snart..kom tilbake senere!";
echo '</div>';
?>