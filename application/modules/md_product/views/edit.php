<div class="row">
    <form action="<?php echo base_url("master-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="image1" src="<?php echo base_url($data['photo_path']); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $data['photo_path'];?>">
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" name="product_code" value="<?php echo $data['product_code'];?>" parsley-trigger="change" required placeholder="Product Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" value="<?php echo $data['product_name'];?>" parsley-trigger="change" required placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="id_product_category" parsley-trigger="change" required placeholder="Category" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($category as $kCategory=>$vCategory) { ?>
                                    <option value="<?php echo $vCategory['id'];?>" <?php echo ($vCategory['id']==$data['id_product_category']?"selected":"");?>><?php echo $vCategory['product_category'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" name="product_price" value="<?php echo $data['product_price'];?>" parsley-trigger="change" required placeholder="Product Price" parsley-type="digits" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['product_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['product_status']=="2"?"selected":"");?>>Non Aktif</option>
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