 <style>
    #map {
     height: 400px;
     width: 100%;
    }
 </style>
<div class="row">
    <div class="col-lg-2">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo base_url($data['photo_path']); ?>" />
            </span>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> NIP </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data['employee_nip']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['employee_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['employee_email']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup"><?php echo $data['employee_phone']; ?></span>
                </div>
            </div>
        </div>
        <br>
        <div class="row" style="padding-left: 24px;">
            <a href="<?php echo site_url('ojt'); ?>" class="btn btn-warning btn-sm">Back</a>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Cust.Code </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['customer_code']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Cust.Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['customer_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Assist.Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['assistant_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Address </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['customer_address']; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-lg-7">
        <div id="map"></div>
    </div>
    <div class="col-lg-5">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Activity </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['activity_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Date </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['sales_visit_date']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Order ID </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['order_id']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Longitude </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['longitude']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Latitude </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['latitude']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Signature </div>
                <div class="profile-info-value">
                    <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo base_url($data['signature_path']); ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function initMap() {
      var uluru = {lat: <?php echo $data['latitude'];?>, lng: <?php echo $data['longitude'];?>};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: uluru
      });
      var marker = new google.maps.Marker({
        position: uluru,
        map: map
      });
    }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('maps_api_key');?>&callback=initMap">
</script>
