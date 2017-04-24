<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/css/bootstrap-duallistbox.min.css" />
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
        <form action="<?php echo site_url("mapping-product-save"); ?>" method="post">
            <div class="form-group">
                <!--<div class="col-sm-8">-->
                <?php log_message('debug',print_r($product,TRUE));?>
                <input type="hidden" name="id_sales" value="<?php echo $data_sales['id']; ?>"/>
                <select multiple="multiple" size="10" name="product[]" id="duallist">
                    <?php
                    foreach ($product as $kProduct => $vProduct) :
                        if(in_array($vProduct['id'], $data_mapping)){
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                    ?>
                        <option value="<?php echo $vProduct['id']; ?>" <?php echo $selected;?>><?php echo $vProduct['product_name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!--<div class="hr hr-16 hr-dotted"></div>
            </div>-->
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
            <a href="<?php echo site_url('mapping-product'); ?>" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>themes/assets/js/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    $(document).ready(function () {
        //var demo1 = $('select[name="product[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
        //var container1 = demo1.bootstrapDualListbox('getContainer');
        //container1.find('.btn').addClass('btn-white btn-info btn-bold');
        
        $("#duallist").bootstrapDualListbox({
            nonSelectedListLabel: 'Non-selected',
            selectedListLabel: 'Selected',
            preserveSelectionOnMove: 'moved',
            //moveOnSelect: false
        });
        
    });
</script>