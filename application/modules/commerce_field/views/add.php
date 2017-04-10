<div class="row">
    <form action="<?php echo base_url("commerce-field-setting-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-9">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product Brand Add</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('commerce_field'); ?>" class="btn btn-default btn-sm pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="commerce_field_name" parsley-trigger="change" required placeholder="Fill Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="commerce_field_description" parsley-trigger="change" required placeholder="Fill Description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="commerce_field_status" placeholder="Pilih Status" required class="form-control">
                                    <option value=""></option>
                                    <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                    <option value="<?php echo $vStatus['code'];?>"><?php echo $vStatus['value'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        
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