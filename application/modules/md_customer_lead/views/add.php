<style>
    #map {
        height: 220px;
        width: 100%;
    }
</style>
<div class="row">
    <form action="<?php echo base_url("lead-customer-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-10">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-lg-3">
                            <img id="image1" src="<?php echo base_url('assets/images/account/user_icon.png'); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" name="customer_code" value="<?php echo $code;?>" readonly="true" parsley-trigger="change" required placeholder="Code" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="customer_name" parsley-trigger="change" required placeholder="Name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Clinic</label>
                                        <input type="text" name="customer_clinic" parsley-trigger="change" required placeholder="Clinic" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select name="customer_province" id="select-province" parsley-trigger="change" required placeholder="Province" class="typeahead form-control">
                                            <option value="" disabled="true" selected> </option>
                                            <?php foreach ($province as $vProvince) : ?>
                                                <option value="<?php echo $vProvince['province_id']; ?>"><?php echo $vProvince['province_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <select name="customer_city" id="select-city" parsley-trigger="change" required placeholder="City" class="typeahead form-control">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>District</label>
                                        <select name="customer_district" id="select-district" parsley-trigger="change" required placeholder="District" class="typeahead form-control">

                                        </select>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Latitude</label>
                                            <input type="text" id="customer-latitude" name="customer_latitude" parsley-trigger="change" required placeholder="Latitude" class="form-control set-map">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" id="customer-longitude" name="customer_longitude" parsley-trigger="change" required placeholder="Longitude" class="form-control set-map">
                                        </div>
                                    </div>
                                    </div>
                                    <div>
                                        <div id="map"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="customer_address" parsley-trigger="change" required placeholder="Address" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" name="customer_phone" parsley-trigger="change" required placeholder="Phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="customer_email" parsley-trigger="change" required placeholder="Email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Source Lead</label>
                                        <select name="id_source_lead_customer" parsley-trigger="change" required placeholder="Group" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($source_lead_customer as $vSource) { ?>
                                                <option value="<?php echo $vSource['id']; ?>"><?php echo $vSource['source_lead_customer']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Lead</label>
                                        <select name="id_status_lead_customer" parsley-trigger="change" required placeholder="Group" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($status_lead_customer as $vStatus) { ?>
                                                <option value="<?php echo $vStatus['id']; ?>"><?php echo $vStatus['status_lead_customer']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Internal Notes</label>
                                        <textarea name="customer_internal_notes" parsley-trigger="change" required placeholder="Notes" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('lead-customer'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function initMap(lat, long) {
        if (lat === undefined && long === undefined) {
            lat = -6.175481;
            long = 106.827187;
        }
        var uluru = {lat: Number(lat), lng: Number(long)};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });

        $("#customer-latitude").val(lat);
        $("#customer-longitude").val(long);
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_E0agZXFwaoiA9PwBG1QmlVrJXKP0GvY&callback=initMap">
</script>
<script>
    $(document).ready(function () {
        
        $(".set-map").focusout(function (){
            initMap($("#customer-latitude").val(), $("#customer-longitude").val());
        });
        
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
                url: "<?php echo base_url(); ?>md_customer_lead/getDistrictList?id=" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    $.each(response, function (index, element) {
                        option += "<option value='" + element.district_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.district_name + "</option>";
                    });
                    $("#select-district").html(option);
                    initMap($("#select-city :selected").data('lat'), $("#select-city :selected").data('lng'));
                }

            });
        });

        $("#select-district").change(function () {
            console.log();
            initMap($("#select-district :selected").data('lat'), $("#select-district :selected").data('lng'));
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image1')
                        .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>