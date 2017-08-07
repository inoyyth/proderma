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
        <div class="col-lg-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-lg-2">
                            <img id="image1" src="<?php echo base_url('assets/images/account/user_icon.png'); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                        </div>
                        <div class="col-lg-5">
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
                                <select name="id_product_category" id="id_product_category" parsley-trigger="change" required placeholder="Category" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($category as $kCategory=>$vCategory) { ?>
                                    <option value="<?php echo $vCategory['id'];?>"><?php echo $vCategory['product_category'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product SubCategory</label>
                                <input type="text" readonly="true" name="product_sub_category" id="product_sub_category" parsley-trigger="change" required placeholder="Product Sub Category" class="form-control">
                                <input type="hidden" readonly="true" name="id_product_sub_category" id="id_product_sub_category" parsley-trigger="change" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Product Group</label>
                                <select name="id_group_product" parsley-trigger="change" required placeholder="Gropp Product" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($group as $kGroup=>$vGroup) { ?>
                                    <option value="<?php echo $vGroup['id'];?>"><?php echo $vGroup['group_product'];?></option>
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
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Sediaan</label>
                                <input type="text" name="sediaan" parsley-trigger="change" required placeholder="Ex. 350gr" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Komposisi</label>
                                <textarea name="komposisi" parsley-trigger="change" required placeholder="Komposisi" class="form-control trumbowyg"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Klasifikasi</label>
                                <textarea name="klasifikasi" parsley-trigger="change" required placeholder="Klasifikasi" class="form-control trumbowyg"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('master-product'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade bs-example-modal-lg" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      
    </div>
    <div class="modal-footer"">
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
        
        $("#product_sub_category").click(function(e){
            e.preventDefault();
            if($("#id_product_category").val() === "") {
                return false;
            } else {
                $("#product-modal .modal-dialog .modal-content #example-table").remove();
                $("#product-modal .modal-dialog .modal-content").append('<div id="example-table"></div>');
                $("#product-modal").modal('show');    
                $("#example-table").tabulator({
                    fitColumns: true,
                    pagination: true,
                    movableCols: true,
                    //height: "320px", // set height of table (optional),
                    pagination:"remote",
                    paginationSize: 10,
                    fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
                    ajaxURL: "<?php echo base_url('md_product_sub_category/getListTable'); ?>", //ajax URL
                    ajaxParams:{category:$("#id_product_category").val()}, //ajax parameters
                    columns: [//Define Table Columns
                        {formatter: "rownum", align: "center", width: 40},
                        {title: "Category", field: "product_category", sorter: "string", tooltip: true},
                        {title: "Sub Category", field: "sub_category_name", sorter: "string", tooltip: true},
                        {title: "Status", field: "status", sorter: "string", tooltip: true}
                    ],
                    selectable: 1,

                });
            }
        });
        
        $("#btn-select-modal").click(function(e){
            var selectedData = $("#example-table").tabulator("getSelectedData");
            //console.log(selectedData[0]);
            $("#product_sub_category").val(selectedData[0].sub_category_name);
            $("#id_product_sub_category").val(selectedData[0].id);
            $("#product-modal").modal('hide');
        });
        
        $("#btn-cancel-modal").click(function(e){
            $("#product-modal").modal('hide');    
        });
        
        $("#id_product_category").change(function (e){
            e.preventDefault();
            $("#product_sub_category").val('');
            $("#id_product_sub_category").val('');
        })
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