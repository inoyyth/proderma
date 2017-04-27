<style>
    #map {
        height: 220px;
        width: 100%;
    }
</style>
<div class="row">
    <div class="col-lg-2">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo base_url($data_sales['photo_path']); ?>" />
            </span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> NIP </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data_sales['employee_nip']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data_sales['employee_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data_sales['employee_email']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup"><?php echo $data_sales['employee_phone']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Gender </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="login"><?php echo ($data_sales['employee_gender'] == "M" ? "Male" : "Female"); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <form action="<?php echo site_url("mapping-area-save"); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $data_sales['id'];?>"/>
            <div class="form-group">
                <label>Province</label>
                <select name="sales_province" id="select-province" parsley-trigger="change" required placeholder="Province" class="typeahead form-control">
                    <option value="" disabled="true" selected> </option>
                    <?php foreach ($province as $vProvince) : ?>
                        <option value="<?php echo $vProvince['province_id']; ?>" <?php echo($data_sales['sales_province']==$vProvince['province_id']?"selected":"");?>><?php echo $vProvince['province_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>City</label>
                <select name="sales_city" id="select-city" parsley-trigger="change" required placeholder="City" class="typeahead form-control">

                </select>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
            <a href="<?php echo site_url('mapping-area'); ?>" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12">
        <div id="map"></div>
    </div>
</div>
<script type="text/javascript">
function initMap(locations) {
    if(locations === undefined){
        var locations = [
          ['Jakarta', -6.175481, 106.827187, 1]
        ];
    }
    
    console.log(locations[0][1]);
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
}
</script>
<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyC_E0agZXFwaoiA9PwBG1QmlVrJXKP0GvY&callback=initMap" type="text/javascript"></script>
<script>
    $(document).ready(function (){
        $("#select-province").change(function () {
            var option = "<option value='' disabled selected> </option>";
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo base_url(); ?>md_customer_lead/getCityList?id=" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    $.each(response, function (index, element) {
                        option += "<option value='" + element.city_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.city_name + "</option>";
                    });
                    $("#select-city").html(option);
                }

            });
        });
        
        $("#select-city").change(function () {
            var option = "<option value='' disabled selected> </option>";
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo base_url(); ?>t_mapping_area/getClinicList?id=" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    initMap(response);
                }

            });
        });
        
        var option = "<option value='' disabled selected> </option>";
        $.ajax({//create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo base_url(); ?>md_customer/getCityList?id=<?php echo $data_sales['sales_province'];?>",
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, element) {
                    if(element.city_id === "<?php echo $data_sales['sales_city'];?>"){
                        option += "<option selected value='" + element.city_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.city_name + "</option>";
                    } else {
                        option += "<option value='" + element.city_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.city_name + "</option>";
                    }
                });
                $("#select-city").html(option);
            }
        }).done(function(){
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo base_url(); ?>t_mapping_area/getClinicList?id=<?php echo $data_sales['sales_city'];?>",
                dataType: "json",
                success: function (response) {
                    initMap(response);
                }

            });
        });
    });
</script>

