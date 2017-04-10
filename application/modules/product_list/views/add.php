<div class="row">
    <form action="<?php echo base_url("product-list-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product List Add</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('product_list'); ?>" class="btn btn-default pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" value="<?php echo $code;?>" readonly="true" name="product_list_sku" parsley-trigger="change" required placeholder="Fill List Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="product_category_id" parsley-trigger="change" required tabindex="-1" class="select2_single form-control">
                                    <option value=""></option>
                                    <?php foreach($product_category as $kCategory=>$vCategory){ ?>
                                    <option value="<?php echo $vCategory['id'];?>"><?php echo $vCategory['product_category_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Brand</label>
                                <select name="product_brand_id" parsley-trigger="change" tabindex="-1" required class="select2_single form-control">
                                    <option value=""></option>
                                    <?php foreach($product_brand as $kBrand=>$vBrand){ ?>
                                    <option value="<?php echo $vBrand['id'];?>"><?php echo $vBrand['product_brand_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_list_name" parsley-trigger="change" required placeholder="Fill Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_list_description" placeholder="Fill Description" class="form-control mytextarea"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_list_status" placeholder="Pilih Status" required class="form-control">
                                    <option value=""></option>
                                    <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                    <option value="<?php echo $vStatus['code'];?>"><?php echo $vStatus['value'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="text" name="product_list_stock" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Stock" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Unit Type</label>
                                <select name="product_list_unit" placeholder="Pilih Status" required class="select2_single form-control">
                                    <option value=""></option>
                                    <?php foreach($params_unit as $kUnit=>$vUnit){ ?>
                                    <option value="<?php echo $vUnit['id'];?>"><?php echo $vUnit['value'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Material Type</label>
                                <input type="text" name="product_list_material" parsley-trigger="change" placeholder="Fill Material Type Ex.Nylon" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Colour</label>
                                <select name="product_list_colour" placeholder="Pilih Status" required class="select2_single form-control">
                                    <option value=""></option>
                                    <?php foreach($params_colour as $kColour=>$vColour){ ?>
                                    <option value="<?php echo $vColour['id'];?>"><?php echo $vColour['value'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label>Length</label>
                                    <input type="text" name="product_list_length" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Length" class="form-control">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Width</label>
                                    <input type="text" name="product_list_width" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Width" class="form-control">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Height</label>
                                    <input type="text" name="product_list_height" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Height" class="form-control">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Weight</label>
                                    <input type="text" name="product_list_weight" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Weigth" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Normal Price</label>
                                <input type="text" name="product_list_normal_price" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Normal Price" class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Special Price</label>
                                    <input type="text" name="product_list_special_price" parsley-trigger="change" data-parsley-type="digits" required placeholder="Fill Special Price" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Reservation Date</label>
                                    <input type="text" name="reservation_date" parsley-trigger="change"  required placeholder="Reservation Date" class="daterange form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_title">
                    <h2>Image Gallery</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" id="addImageList" name="addImageList" class="btn btn-primary btn-sm"><i class="fa fa-camera-retro"></i> Add Image</button>
                            <div id="imageListContent">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_title">
                    <h2>Video Gallery</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" id="addVideoList" name="addVideoList" class="btn btn-primary btn-sm"><i class="fa fa-video-camera"></i> Add Video</button>
                            <div id="videoListContent">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="myModalVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelVideo"></h4>
      </div>
      <div class="modal-body" id="myModalBodyVideo">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>themes/vendors/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var imageError = "<?php echo base_url('assets/images/user_icon.png');?>";
        var i=1;
        $("#addImageList").click(function(){
            i++;
            $("#imageListContent").append("<div class='col-lg-3' id='imgproduct-"+i+"'>\n\
                    <div class='thumbnail'>\n\
                        <input required='true' style='margin-bottom:10px;' type='file' name='userfile[]' onchange='readURL(this,"+i+");' >\n\
                        <img class='img-responsive' style='height:100px;' id='imagelist-"+i+"' src='"+imageError+"'>\n\
                        <div class='pull-right' style='margin-top:10px;'><button type='button' class='btn btn-warning btn-sm' onclick='delimage("+i+")'>Delete</button></div>\n\
                    </div>\n\
                </div>");
        }); 
        
        $("#addVideoList").click(function(){
            i++;
            $("#videoListContent").append("<div class='col-lg-4'id='vidproduct-"+i+"'>\n\
                    <div class='thumbnail' style='height:auto;'>\n\
                        <div class='form-group col-lg-12'>\n\
                            <label>Title</label>\n\
                            <input required='true' id='video-title-"+i+"' required name='video_title[]' type='text' class='form-control' >\n\
                            <label>URL</label>\n\
                            <input required='true' id='video-url-"+i+"' required name='video_url[]' style='margin-bottom:10px;' type='text' class='form-control'' >\n\
                        </div>\n\
                        <div class='form-group col-lg-6'>\n\
                            <label>Width</label>\n\
                            <input type='text' id='video-width-"+i+"' required name='video_width[]' class='form-control'>\n\
                        </div>\n\
                        <div class='form-group col-lg-6'>\n\
                            <label>Height</label>\n\
                            <input type='text' id='video-height-"+i+"' required name='video_height[]' class='form-control'>\n\
                        </div>\n\
                        <div class='pull-right' style='margin-top:5px;'>\n\
                            <label>\n\
                              <input type='hidden'  name='video_show[]' id='video_show-"+i+"' value='2'>\n\
                              <input value='2' onchange='cekCheckboxes(this,"+i+");' type='checkbox'><span> Active </span>\n\
                            </label>\n\
                            <button type='button' class='btn btn-warning btn-sm' onclick='showvideo("+i+")'>Show</button>\n\
                            <button type='button' class='btn btn-danger btn-sm' onclick='delvideo("+i+")'>Delete</button>\n\
                        </div>\n\
                    </div>\n\
                </div>");
        }); 
        
        $('#myModalVideo').on('hidden.bs.modal', function () {
            var iframe = $(this).find('iframe');
            var src = iframe.attr('src');
            iframe.attr('src', '');
            iframe.attr('src', src);
        });
     });
     
    function readURL(input,id){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagelist-"+id).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function delimage(id){
        $("#imgproduct-"+id).remove();
    }
    
    function delvideo(id){
        $("#vidproduct-"+id).remove();
    }
    
    function cekCheckboxes(checkbox,id){
        console.log(id);
        if (checkbox.checked){
            $("#video_show-"+id).val('1');
            checkbox.value = '1';
        }else{
            $("#video_show-"+id).val('2');
            checkbox.value = '2';
        }
    }
    
    function showvideo(i) {
        var urlVideo = $("#video-url-"+i).val();
        var strUrl = urlVideo.replace("https://youtu.be/", "https://www.youtube.com/embed/"); 
        var linkVideo = '<iframe width="560" height="315" src="'+strUrl+'" frameborder="0" allowfullscreen></iframe>';
        $("#myModalLabelVideo").text($("#video-title-"+i).val());
        $("#myModalBodyVideo").html(linkVideo);
        $("#myModalVideo").modal('show');
    }
</script>