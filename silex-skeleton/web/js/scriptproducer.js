function myMap() {

      var myLatLng = {lat: 48.4333, lng: 2.15};
    
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3,
          center: myLatLng
        });
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
      }