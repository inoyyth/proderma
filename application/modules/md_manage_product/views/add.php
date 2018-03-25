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
    <form action="<?php echo base_url("manage-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-lg-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="hidden" name="id_product" value="<?php echo $data['id'];?>">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" value="<?php echo $data['product_name'];?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Transaction Status</label>
                                <select name="update_status" parsley-trigger="change" required  class="form-control">
                                    <option value="I">IN</option>
                                    <option value="O">OUT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="text" name="qty" parsley-trigger="change" parsley-type="digits" required placeholder="Ex. 10" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" parsley-trigger="change" required placeholder="Ex. Barang Tambahan Dari Gudang A" class="form-control trumbowyg"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('manage-product-list-'.$data['id']); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade bs-example-modal-lg" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary btn-sm" id="btn-select-modal">Select</button> 
        <button class="btn btn-danger btn-sm" id="btn-cancel-modal">Cancel</button>
    </div>
  </div>
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