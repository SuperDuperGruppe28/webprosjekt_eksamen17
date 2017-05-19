  google.maps.event.addDomListener(window, 'load', init);

  function init() {
      var mapOptions = {
          zoom: 14,

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

  function startMaps(x, y, side) {
      var mapOptions = {
          zoom: 14,

          center: new google.maps.LatLng(x, y), // Vulkan, Oslo
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

      var mapElement = document.getElementById('mapaktivitet');
      var map = new google.maps.Map(mapElement, mapOptions);
      marker = new google.maps.Marker({
          position: new google.maps.LatLng(x, y),
          map: map,
          draggable: side,
          title: 'Vulkan'
      });

      if (side) {
          google.maps.event.addListener(marker, 'dragend', function () {
              settKoordinater(marker.getPosition().lat(), marker.getPosition().lng())
          });
          settKoordinater(marker.getPosition().lat(), marker.getPosition().lng());
      }
  }

  // Setter koordinatene fra map til Post submit
  function settKoordinater(x, y) {
      console.log("x: " + x + " Y: " + y);
      document.getElementById("breddegrad").value = x;
      document.getElementById("lengdegrad").value = y;
  }
