<style>
    #map {
        height: 220px;
        width: 100%;
    }
</style>
<div class="row">
    <form action="<?php echo base_url("customer-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-10">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-lg-3">
                            <img id="image1" src="<?php echo base_url($data['photo_path']); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $data['photo_path'];?>">
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" name="customer_code" value="<?php echo $data['customer_code'];?>" readonly="true" parsley-trigger="change" required placeholder="Code" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="customer_name" value="<?php echo $data['customer_name'];?>" parsley-trigger="change" required placeholder="Name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Clinic</label>
                                        <input type="text" name="customer_clinic" value="<?php echo $data['customer_clinic'];?>" parsley-trigger="change" required placeholder="Clinic" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select name="customer_province" id="select-province" parsley-trigger="change" required placeholder="Province" class="typeahead form-control">
                                            <option value="" disabled="true" selected> </option>
                                            <?php foreach ($province as $vProvince) : ?>
                                                <option value="<?php echo $vProvince['province_id']; ?>" <?php echo ($data['customer_province']==$vProvince['province_id']?"selected":"") ;?>><?php echo $vProvince['province_name']; ?></option>
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
                                            <input type="text" id="customer-latitude" name="customer_latitude" value="<?php echo $data['customer_latitude'];?>" parsley-trigger="change" required placeholder="Latitude" class="form-control set-map">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" id="customer-longitude" name="customer_longitude" value="<?php echo $data['customer_longitude'];?>" parsley-trigger="change" required placeholder="Longitude" class="form-control set-map">
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
                                        <textarea name="customer_address" parsley-trigger="change" required placeholder="Address" class="form-control"><?php echo $data['customer_address'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" name="customer_phone" value="<?php echo $data['customer_phone'];?>" parsley-trigger="change" required placeholder="Phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="customer_email" value="<?php echo $data['customer_email'];?>" parsley-trigger="change" required placeholder="Email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Group</label>
                                        <select name="id_group_customer_product" parsley-trigger="change" required placeholder="Group" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($group as $vGroup) { ?>
                                                <option value="<?php echo $vGroup['id']; ?>" <?php echo ($data['id_group_customer_product']==$vGroup['id']?"selected":"");?>><?php echo $vGroup['group_customer_product']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Area</label>
                                        <select name="id_area" id="select-area" parsley-trigger="change" required placeholder="Area" class="form-control">
                                            <option value="" disabled="true" selected> </option>
                                            <?php foreach ($area as $vArea) { ?>
                                                <option value="<?php echo $vArea['id']; ?>" <?php echo($data['id_area']==$vArea['id'] ? "selected" : "");?>><?php echo $vArea['area_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>SubArea</label>
                                        <select name="id_subarea" id="select-subarea" parsley-trigger="change" required placeholder="City" class="typeahead form-control">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="id_status_list_customer" parsley-trigger="change" required placeholder="Status" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($status_list_customer as $vStatus) { ?>
                                                <option value="<?php echo $vStatus['id']; ?>" <?php echo ($data['id_status_list_customer']==$vStatus['id']?"selected":"");?>><?php echo $vStatus['status_list_customer']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Internal Notes</label>
                                        <textarea name="customer_internal_notes" parsley-trigger="change" required placeholder="Notes" class="form-control"><?php echo $data['customer_internal_notes'];?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('customer'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function initMap(lat, long) {
        if (lat === undefined && long === undefined) {
            lat = $("#customer-latitude").val();
            long = $("#customer-longitude").val();
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
        //initMap($("#customer-latitude").val(), $("#customer-longitude").val());
        var option = "<option value='' disabled selected> </option>";
        $.ajax({//create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo base_url(); ?>md_customer/getCityList?id=<?php echo $data['customer_province'];?>",
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, element) {
                    if(element.city_id === "<?php echo $data['customer_city'];?>"){
                        option += "<option selected value='" + element.city_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.city_name + "</option>";
                    } else {
                        option += "<option value='" + element.city_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.city_name + "</option>";
                    }
                });
                $("#select-city").html(option);
            }

        });
        
        var option_district = "<option value='' disabled selected> </option>";
        $.ajax({//create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo base_url(); ?>md_customer/getDistrictList?id=<?php echo $data['customer_city'];?>",
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, element) {
                    if(element.district_id === "<?php echo $data['customer_district'];?>"){
                        option_district += "<option selected value='" + element.district_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.district_name + "</option>";
                    } else {
                        option_district += "<option value='" + element.district_id + "' data-lat='" + element.lat + "' data-lng='" + element.lng + "'>" + element.district_name + "</option>";
                    }
                });
                $("#select-district").html(option_district);
            }

        });
        
        var option_subarea = "<option value='' disabled selected> </option>";
        $.ajax({//create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo base_url(); ?>md_customer/getSubareaList?id=<?php echo $data['id_area'];?>",
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, element) {
                    if(element.id === "<?php echo $data['id_subarea'];?>"){
                        option_subarea += "<option selected value='" + element.id + "'>" + element.subarea_name + "</option>";
                    } else {
                        option_subarea += "<option value='" + element.id + "'>" + element.subarea_name + "</option>";
                    }
                });
                $("#select-subarea").html(option_subarea);
            }

        });
        
        $(".set-map").focusout(function (){
            initMap($("#customer-latitude").val(), $("#customer-longitude").val());
        });
        
        $("#select-province").change(function () {
            var option = "<option value='' disabled selected> </option>";
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo base_url(); ?>md_customer/getCityList?id=" + $(this).val(),
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
                url: "<?php echo base_url(); ?>md_customer/getDistrictList?id=" + $(this).val(),
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
        
        $("#select-area").change(function () {
            var option = "<option value='' disabled selected> </option>";
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo base_url(); ?>md_customer/getSubareaList?id=" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    $.each(response, function (index, element) {
                        option += "<option value='" + element.id + "'>" + element.subarea_name + "</option>";
                    });
                    $("#select-subarea").html(option);
                }

            });
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