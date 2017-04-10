<div class="row">
    <form action="<?php echo base_url("product-brand-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product Brand Edit</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('product-brand'); ?>" class="btn btn-default pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                         <div class="col-md-4">
                            <img id="image1" src="<?php echo (!empty($detail['path_foto']) ? cloudinary_url($detail['path_foto'].".png", array( "alt" => "User Image" )) : base_url('assets/images/user_icon.png')); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $detail['path_foto']; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Brand Code</label>
                                <input type="hidden" name="id" value="<?php echo $detail['id'];?>">
                                <input type="text" value="<?php echo $detail['product_brand_code'];?>" readonly="true" name="product_brand_code" parsley-trigger="change" required placeholder="Fill Brand Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Brand Name</label>
                                <input type="text" value="<?php echo $detail['product_brand_name'];?>" name="product_brand_name" parsley-trigger="change" required placeholder="Fill Brand Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_brand_description" placeholder="Fill Brand Description" class="form-control mytextarea"><?php echo $detail['product_brand_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_brand_status" placeholder="Pilih Status" required class="form-control">
                                    <option value=""></option>
                                    <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                    <option value="<?php echo $vStatus['code'];?>" <?php echo ($detail['product_brand_status']==$vStatus['code']?"selected":"");?>><?php echo $vStatus['value'];?></option>
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