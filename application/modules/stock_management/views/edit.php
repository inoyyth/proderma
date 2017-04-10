<div class="row">
    <form action="<?php echo base_url("product-category-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product Category Edit</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('product-category'); ?>" class="btn btn-default pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category Code</label>
                                <input type="hidden" name="id" value="<?php echo $detail['id'];?>">
                                <input type="text" value="<?php echo $detail['product_category_code'];?>" readonly="true" name="product_category_code" parsley-trigger="change" required placeholder="Fill Category Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" value="<?php echo $detail['product_category_name'];?>" name="product_category_name" parsley-trigger="change" required placeholder="Fill Category Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_category_description" placeholder="Fill Category Description" class="form-control mytextarea"><?php echo $detail['product_category_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_category_status" placeholder="Pilih Status" required class="form-control">
                                    <option value=""></option>
                                    <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                    <option value="<?php echo $vStatus['code'];?>" <?php echo ($detail['product_category_status']==$vStatus['code']?"selected":"");?>><?php echo $vStatus['value'];?></option>
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