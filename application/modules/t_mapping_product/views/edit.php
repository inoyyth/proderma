<link rel="stylesheet" href="<?php echo base_url();?>themes/assets/css/bootstrap-duallistbox.min.css" />
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
                <div class="profile-info-name"> Username </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username">alexdoe</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Location </div>

                <div class="profile-info-value">
                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                    <span class="editable editable-click" id="country">Netherlands</span>
                    <span class="editable editable-click" id="city">Amsterdam</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Age </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="age">38</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Joined </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup">2010/06/20</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Last Online </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="login">3 hours ago</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> About Me </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="about">Editable as WYSIWYG</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <!--<div class="col-sm-8">-->
                <select multiple="multiple" size="10" name="duallistbox_demo1[]" id="duallist">
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3" selected="selected">Option 3</option>
                    <option value="option4">Option 4</option>
                    <option value="option5">Option 5</option>
                    <option value="option6" selected="selected">Option 6</option>
                    <option value="option7">Option 7</option>
                    <option value="option8">Option 8</option>
                    <option value="option9">Option 9</option>
                    <option value="option0">Option 10</option>
                </select>

                <!--<div class="hr hr-16 hr-dotted"></div>
            </div>-->
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>themes/assets/js/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    $(document).ready(function(){
       var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(); 
    });
</script>