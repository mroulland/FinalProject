var map;
      function initMap() {
          map = new google.maps.Map(document.getElementById("map"), {
            center: {lat: 48.853, lng: 2.350},
            zoom: 13
          });

          var layer = new google.maps.FusionTablesLayer({
              query: {
              select: '\'Adresse\'',
              from: '1vfNFuU6cokxH7ZyKovuLyocXOdHyOGP8rp7Z49cz'
              }
          });
  
          layer.setMap(map);
      }
      
      