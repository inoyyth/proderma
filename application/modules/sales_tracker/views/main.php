<div class="row">
    <div class="col-lg-12">
        <button onclick="loadMap();">LoadMap</button>
        <div id="map" style="width: 100%; height: 500px;"></div>
    </div>
</div>
<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyC_E0agZXFwaoiA9PwBG1QmlVrJXKP0GvY&callback=initMap" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    loadMap();
});
    function loadMap() {
        $.ajax({
                url: "<?php echo base_url('sales_tracker/getLog');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: {}
        }).done(function(e) {
            /*var locations = [
                ['Rumah Sakit', -6.211544, 106.845172, 4],
                ['Coogee Beach', -33.923036, 151.259052, 5],
                ['Cronulla Beach', -34.028249, 151.157507, 3],
                ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
                ['Maroubra Beach', -33.950198, 151.259302, 1]
            ];*/
            var locations = e;
           

            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 5,
              center: new google.maps.LatLng(-6.211544, 106.845172),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {  
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                title: locations[i][0]
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
        }).fail(function() {
            console.log( "error" );
        }).always(function() {
            console.log( "complete" );
        });
    }
    
    
</script>