<div id="user-profile-1" class="user-profile row">
    <div class="col-xs-12 col-sm-3 center">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" style="height: 143px;" alt="<?php echo $customer['customer_name']; ?>" src="<?php echo base_url($customer['photo_path']); ?>" />
            </span>

            <div class="space-4"></div>

            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">

                    <i class="ace-icon fa fa-circle light-green"></i>
                    &nbsp;
                    <span class="white"><?php echo $customer['customer_code'];?></span>

                </div>
            </div>
        </div>

        <div class="space-6"></div>

    </div>

    <div class="col-xs-12 col-sm-9">

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Name </div>

                <div class="profile-info-value">
                    <span class="editable" id="username"><?php echo $customer['customer_name'];?></span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Clinic </div>

                <div class="profile-info-value">
                    <span class="editable" id="city"><?php echo $customer['customer_clinic'];?></span>
                </div>
            </div>
            
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>

                <div class="profile-info-value">
                    <span class="editable" id="login"><?php echo $customer['customer_email'];?></span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Group </div>

                <div class="profile-info-value">
                    <div class="form-group">
                        <select name="id_group_customer_product" parsley-trigger="change" required placeholder="Group" class="form-control">
                            <option value=""></option>
                            <?php foreach ($group as $vGroup) { ?>
                                <option value="<?php echo $vGroup['id']; ?>" <?php echo ($customer['id_group_customer_product']==$vGroup['id']?"selected":"");?>><?php echo $vGroup['group_customer_product']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Area </div>

                <div class="profile-info-value">
                    <span class="editable" id="signup"><?php echo $customer['area_code'] . " / ". $customer['area_name'];?></span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Sub Area </div>

                <div class="profile-info-value">
                    <span class="editable" id="login"><?php echo $customer['subarea_code'] . " / ". $customer['subarea_name'];?></span>
                </div>
            </div>
            
        </div>

        <div class="space-20"></div>
    </div>
    
</div>