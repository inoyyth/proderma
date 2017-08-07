<div class="row">
    <form action="<?php echo base_url("master-product-sub-category-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>Product Category</label>
                                <select name="id_product_category" parsley-trigger="change" required placeholder="Product Category" class="form-control">
                                    <option value="" selected="true" disabled="true">- select product category -</option>
                                    <?php foreach($product_category as $v) { ?>
                                    <option value="<?php echo $v['id'];?>" <?php echo ($data['id_product_category']==$v['id']?"selected":"");?>><?php echo $v['product_category'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label>
                                <input type="text" name="sub_category_name" value="<?php echo $data['sub_category_name'];?>" parsley-trigger="change" required placeholder="Sub Category" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_sub_category_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['product_sub_category_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['product_sub_category_status']=="2"?"selected":"");?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('master-product-category'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>