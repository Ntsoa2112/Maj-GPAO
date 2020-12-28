<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%; }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script type="text/javascript">

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -18.918410, lng: 47.543186},
    zoom: 17
  });

var _position = new google.maps.LatLng(-18.918410, 47.543186);

var easy = new google.maps.Marker({
        position: _position ,
        map: map,
        title: 'EASYTECH MADAGASCAR',
        animation: google.maps.Animation.DROP,
        content: "<p style='color:#000;'><b>EASYTECH MADAGASCAR NOUVEAU LOCAL</b></p>"
    });

}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_3tNUBCAeWoTHRvhg1V4zJzVrcgO-zMA&callback=initMap">
    </script>
  </body>
</html>