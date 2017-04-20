<style>
    #map {
      height: 400px;
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
                            <img id="image1" src="<?php echo base_url('assets/images/account/user_icon.png'); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" name="customer_code" parsley-trigger="change" required placeholder="Code" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Clinic</label>
                                        <input type="text" name="customer_clinic" parsley-trigger="change" required placeholder="Clinic" class="form-control">
                                    </div>
                                    <div class="form-group" id="remote-province">
                                        <label>Province</label>
                                        <input type="hidden" name="id_province" id="id_province">
                                        <input type="text" name="customer_province" parsley-trigger="change" required placeholder="Province" class="typeahead form-control">
                                    </div>
                                    <div class="form-group" id="remote-city">
                                        <label>City</label>
                                        <input type="hidden" name="id_city" id="id_city">
                                        <input type="text" name="customer_city" parsley-trigger="change" required placeholder="City" class="typeahead form-control">
                                    </div>
                                    <div class="form-group" id="remote-district">
                                        <label>District</label>
                                        <input type="hidden" name="id_district" id="id_district">
                                        <input type="text" name="customer_district" parsley-trigger="change" required placeholder="District" class="typeahead form-control">
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
                                        <input type="email" name="customer_district" parsley-trigger="change" required placeholder="Email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Group</label>
                                        <select name="id_group_customer_product" parsley-trigger="change" required placeholder="Group" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($group as $vGroup) { ?>
                                                <option value="<?php echo $vGroup['id']; ?>"><?php echo $vGroup['group_customer_product']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Internal Notes</label>
                                        <textarea name="customer_internal_notes" parsley-trigger="change" required placeholder="Notes" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="customer_status" placeholder="Status" required class="form-control">
                                            <option value="1">Aktif</option>
                                            <option value="2">Non Aktif</option>
                                        </select>
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
    $(document).ready(function () {
        //autocomplete
        var searchDataProvince = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo base_url('md_customer/getProvinceList?query=%QUERY'); ?>',
                wildcard: '%QUERY'
            }
        });

        $('#remote-province .typeahead').typeahead(null, {
            name: 'province_name',
            display: 'province_name',
            source: searchDataProvince,
            minLength: 3,
            highlight: true,
            limit: 10
        });

        $('#remote-province .typeahead').bind('typeahead:selected', function (obj, datum, name) {
            $("#id_province").val(datum.province_id);
        });

        var searchDataCity = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo base_url();?>md_customer/getCityList?query=%QUERY',
                wildcard: '%QUERY',
                replace: function(url, uriEncodedQuery) {
                    province = $('#id_province').val();
                    if (!province) return url.replace("%QUERY",uriEncodedQuery);
                    return url.replace("%QUERY",uriEncodedQuery) + '&province=' + encodeURIComponent(province)
                },
            } 
        });

        $('#remote-city .typeahead').typeahead(null, {
            name: 'city_name',
            display: 'city_name',
            source: searchDataCity,
            minLength: 3,
            highlight: true,
            limit: 10
        });

        $('#remote-city .typeahead').bind('typeahead:selected', function (obj, datum, name) {
            $("#id_city").val(datum.city_id);
        });

        var searchDataDistrict = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo base_url();?>md_customer/getDistrictList?query=%QUERY',
                wildcard: '%QUERY',
                replace: function(url, uriEncodedQuery) {
                    city = $('#id_city').val();
                    if (!city) return url.replace("%QUERY",uriEncodedQuery);
                    return url.replace("%QUERY",uriEncodedQuery) + '&city=' + encodeURIComponent(city)
                },
            }
        });

        $('#remote-district .typeahead').typeahead(null, {
            name: 'district_name',
            display: 'district_name',
            source: searchDataDistrict,
            minLength: 3,
            highlight: true,
            limit: 10
        });

        $('#remote-district .typeahead').bind('typeahead:selected', function (obj, datum, name) {
            $("#id_district").val(datum.city_id);
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

<script>
    function initMap() {
      var uluru = {lat: -25.363, lng: 131.044};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru
      });
      var marker = new google.maps.Marker({
        position: uluru,
        map: map
      });
    }
</script>
 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_E0agZXFwaoiA9PwBG1QmlVrJXKP0GvY&callback=initMap">
</script>