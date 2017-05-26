<?php
function initMap() {
  var latLng = new google.maps.LatLng(49.47805, -123.84716);
  var homeLatLng = new google.maps.LatLng(49.47805, -123.84716);

  var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 12,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  var marker = new MarkerWithLabel({
    position: homeLatLng,
    map: map,
    draggable: true,
    raiseOnDrag: true,
    labelContent: "ABCD",
    labelAnchor: new google.maps.Point(15, 65),
    labelClass: "labels", // the CSS class for the label
    labelInBackground: false,
    icon: pinSymbol('red')
  });

  var iw = new google.maps.InfoWindow({
    content: "Home For Sale"
  });
  google.maps.event.addListener(marker, "click", function(e) {
    iw.open(map, this);
  });
}

function pinSymbol(color) {
  return {
    path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
    fillColor: color,
    fillOpacity: 1,
    strokeColor: '#000',
    strokeWeight: 2,
    scale: 2
  };
}
google.maps.event.addDomListener(window, 'load', initMap);