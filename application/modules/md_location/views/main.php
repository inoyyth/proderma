<div class="row">
    <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
        <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title smaller">Location Info Panels</h6>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <form class="form-filter-table">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Province</label>
                                    <select name="province" id="province" class="form-control">
                                        <option value="" selected="true" disabled="true"> - select province -</option>
                                        <?php foreach ($province as $kProvince=>$vProvince) { ?>
                                        <option value="<?php echo $vProvince['province_id'];?>"><?php echo $vProvince['province_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">City</label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="" selected="true" disabled="true"> - select city -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">District</label>
                                    <select name="district" id="district" class="form-control">
                                        <option value="" selected="true" disabled="true"> - select district -</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <form class="form-filter-table">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Province ID</label>
                                    <input type="text" readonly="true" id="province_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">City ID</label>
                                    <input type="text" readonly="true" id="city_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">District ID</label>
                                    <input type="text" readonly="true" id="district_id" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $('#province').change(function(){
           $("#province_id").val($(this).val()); 
           var optCity = '<option value="" selected="true" disabled="true"> - select city -</option>';
           var optDistrict = '<option value="" selected="true" disabled="true"> - select district -</option>';
           $.ajax({
                url:'<?php echo base_url('md_location/getLocation');?>',
                data:{table:'city',field:'province_id',where:$(this).val()},
                type:'POST',
                dataType:'json',
                success: function (e,status) {
                    console.log(status);
                },
                error: function (e,status) {
                    console.log(status);
                }
           }).done(function(e){
               $.each(e, function (i,item){
                  optCity += '<option value="'+item.city_id+'">'+item.city_name+'</option>'; 
               });
               $('#city').html(optCity);
               $('#district').html(optDistrict);
               $("#city_id,#district_id").val('');
           })
        });
        
        $('#city').change(function(){
           $("#city_id").val($(this).val()); 
           var optDistrict = '<option value="" selected="true" disabled="true"> - select district -</option>';
           $.ajax({
                url:'<?php echo base_url('md_location/getLocation'); ?>',
                data:{table:'district',field:'city_id',where:$(this).val()},
                type:'POST',
                dataType:'json',
                success: function (e,status) {
                    console.log(status);
                },
                error: function (e,status) {
                    console.log(status);
                }
           }).done(function(e){
               $.each(e, function (i,item){
                  optDistrict += '<option value="'+item.district_id+'">'+item.district_name+'</option>'; 
               });
               $('#district').html(optDistrict);
               $("#district_id").val('');
           })
        });
        
        $('#district').change(function(){
            $("#district_id").val($(this).val());
        });
    });
</script>