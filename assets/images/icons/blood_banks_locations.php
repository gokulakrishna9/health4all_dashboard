<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        var ongole = {lat: 15.5057, lng: 80.0499};
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 15.9129, lng: 79.7400},
          zoom: 8
        });
        
        contentString = "<table>"+
                +"<tr><td>A+</td><td>10</td></tr>"
                +"<tr><td>A-</td><td>11</td></tr>"
                +"<tr><td>AB+</td><td>12</td></tr>"
                +"<tr><td>B+</td><td>13</td></tr>"
                +"<tr><td>O+</td><td>14</td></tr>"
                +"<tr><td>O-</td><td>15</td></tr>"
                +"<tr><td>AB-</td><td>16</td></tr>"                
                +"</table>";
        
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var image = "<?php echo base_url() ?>assets/images/icons/bloodbank_marker.png";
        var marker = new google.maps.Marker({
            position: ongole,
            map: map,
            title: 'Ongole Bloodbank',
            icon: image
        });
        
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgts0v9kmBp-Ewq6Ch3bhZQMlI2lZxM6g&callback=initMap"
    async defer></script>
  </body>
</html>