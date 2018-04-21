<link rel="stylesheet" href="<?php echo base_url('themes/assets/plugin/Trumbowyg-master/dist/ui/trumbowyg.min.css');?>">
<style>
    .trumbowyg-box.trumbowyg-editor-visible {
  min-height: 150px;
}

.trumbowyg-editor {
  min-height: 150px;
}
</style>
<div class="row">
    <form action="<?php echo base_url("master-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-2">
                            <img id="image1" src="<?php echo base_url($data['photo_path']); ?>" alt="..." class="img-circle img-responsive">
                        </div>
                        <div class="col-md-5">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" name="product_code" value="<?php echo $data['product_code'];?>" parsley-trigger="change" required placeholder="Product Code" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" value="<?php echo $data['product_name'];?>" parsley-trigger="change" required placeholder="Product Name" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" name="id_product_category" value="<?php echo $data['product_category'];?>" parsley-trigger="change" required placeholder="Product Name" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Product SubCategory</label>
                                <input type="text" name="id_product_sub_category" value="<?php echo $data['sub_category_name'];?>" parsley-trigger="change" required placeholder="Product Name" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Product Group</label>
                                <input type="text" name="id_group_product" value="<?php echo $data['group_product'];?>" parsley-trigger="change" required placeholder="Product Name" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" name="product_price" value="<?php echo formatrp($data['product_price']);?>" parsley-trigger="change" required placeholder="Product Price" parsley-type="digits" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" name="product_status" value="<?php echo ($data['product_status']=="1"?"Aktif":"Non Aktif");?>" parsley-trigger="change" required placeholder="Product Name" class="form-control" readonly="true">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Sediaan</label>
                                <input type="text" name="sediaan" value="<?php echo $data['sediaan'];?>" parsley-trigger="change" required placeholder="Ex. 350gr" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label>Komposisi</label>
                                <textarea name="komposisi" parsley-trigger="change" required placeholder="Komposisi" class="form-control trumbowyg" readonly="true"><?php echo $data['komposisi'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Klasifikasi</label>
                                <textarea name="klasifikasi" parsley-trigger="change" required placeholder="Klasifikasi" class="form-control trumbowyg" readonly="true"><?php echo $data['klasifikasi'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url('master-product'); ?>" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo base_url('themes/assets/plugin/Trumbowyg-master/dist/trumbowyg.min.js');?>"></script>
<script>
    $(document).ready(function (){
        $('.trumbowyg').trumbowyg({
            btns: [
                ['viewHTML'],
                //['formatting'],
                'btnGrp-semantic',
                ['superscript', 'subscript'],
                //['link'],
                //['insertImage'],
                'btnGrp-justify',
                'btnGrp-lists',
                //['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
            autogrow: true,
            autoAjustHeight: false,
        });
    });
</script>