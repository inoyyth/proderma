<div class="row">
    <form action="<?php echo base_url("master-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="image1" src="<?php echo base_url('assets/images/account/user_icon.png'); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" name="product_code" parsley-trigger="change" required placeholder="Product Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" parsley-trigger="change" required placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="id_product_category" parsley-trigger="change" required placeholder="Category" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($category as $kCategory=>$vCategory) { ?>
                                    <option value="<?php echo $vCategory['id'];?>"><?php echo $vCategory['product_category'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" name="product_price" parsley-trigger="change" required placeholder="Product Price" parsley-type="digits" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('master-product'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
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