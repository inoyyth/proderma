<div class="row">
    <form action="<?php echo base_url("stock-management-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Stock Management</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <input type="reset" class="btn btn-default btn-sm pull-right" value="Reset"></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="remote">
                                <label>Product SKU</label>
                                <input type="hidden" name="product_id" id="product_id">
                                <input style="text-transform: uppercase;" type="text" id="product_sku" class="typeahead form-control"  parsley-trigger="change" required placeholder="Insert Product SKU">
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" id="product_name" parsley-trigger="change" required readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Total</label>
                                <input type="text" name="jumlah"  data-parsley-type="digits" parsley-trigger="change" required placeholder="Fill Category Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="tanggal" parsley-trigger="change" required placeholder="Select Date" class="form-control datepickersingle">
                            </div>
                            <div class="form-group">
                                <label>Stock In Or Out</label>
                                <select type="text" name="add_or_min" parsley-trigger="change" required class="form-control">
                                    <option value="1">IN</option>
                                    <option value="2">OUT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" parsley-trigger="change" required placeholder="Fill Description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Product <small>List</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 200px;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($data) < 1) {
                                echo"<tr><td class='text-center' colspan='10'>-No Data Found-</td></tr>";
                            } else {
                                foreach ($data as $k => $v) {
                                    ?>
                                    <tr>
                                        <td><?php echo intval($this->uri->segment(2) + ($k + 1)); ?></td>
                                        <td><?php echo $v['product_list_sku']; ?></td>
                                        <td><?php echo $v['product_category_name']; ?></td>
                                        <td><?php echo $v['product_brand_name']; ?></td>
                                        <td><?php echo $v['product_list_name']; ?></td>
                                        <td><?php echo $v['total']; ?></td>
                                        <td><?php echo get_status($v['product_list_status']); ?></td>
                                        <td class="text-center">
                                           <button class="btn btn-sm btn-warning" onclick="detailStockBtn('<?php echo $v['id']; ?>');"><i class="fa fa-info-circle"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <form id="form1" method="post" action="<?php echo base_url('stock-management'); ?>">
                            <tr>
                                <td>#</td>
                                <td>
                                    <input class="form-control input-sm" name="product_list_sku" class="form-control" value="<?php echo (isset($sr_data['product_list_sku']) ? $sr_data['product_list_sku'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm" name="product_category_name" class="form-control" value="<?php echo (isset($sr_data['product_category_name']) ? $sr_data['product_category_name'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm" name="product_brand_name" class="form-control" value="<?php echo (isset($sr_data['product_brand_name']) ? $sr_data['product_brand_name'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm" name="product_list_name" class="form-control" value="<?php echo (isset($sr_data['product_list_name']) ? $sr_data['product_list_name'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <select class="form-control input-sm" style="margin-top: 5px;" name="product_list_status" onchange="submit_search('form1');">                         
                                        <option value=""></option>
                                        <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                        <option value="<?php echo $vStatus['code'];?>" <?php echo (isset($sr_data['product_list_status']) && $sr_data['product_list_status']==$vStatus['code']?"selected":"");?>><?php echo $vStatus['value'];?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            <td>&nbsp;</td>
                            </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 pull-left text-left">	
                    <select class="form-control input-sm" name="page" onchange="submit_search('form1');"/>
                    <option value="10" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "10" ? "selected" : ""); ?>>10</option>
                    <option value="25" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "25" ? "selected" : ""); ?>>25</option>
                    <option value="50" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "50" ? "selected" : ""); ?>>50</option>
                    <option value="100" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "100" ? "selected" : ""); ?>>100</option>
                    </select>
                </div>
                </form>
                <div class="col-lg-3 pull-left">
                    <?php echo generate_page_count_table($this->uri->segment(2),$sr_data['page'],$total_rows);?>
                </div>
                <div class="col-lg-8 pull-right text-right">	
                    <?php echo $paging; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail-->
<div class="modal fade bs-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detail History</h4>
            </div>
            <div class="modal-body">
                <table style="width: 100%;" class="display table table-bordered table-hover" id="listDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>
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
    $(document).ready(function () {
        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo base_url('stock_management/get_product_sku?query=%QUERY'); ?>',
                wildcard: '%QUERY'
            }
        });

        $('#remote .typeahead').typeahead(null, {
            name: 'product_list_sku',
            display: 'product_list_sku',
            source: bestPictures
        });

        $('#remote .typeahead').bind('typeahead:selected', function (obj, datum, name) {
            console.log(datum);
            $('#product_list_sku').val(datum.product_list_sku);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('stock_management/get_detail_product'); ?>",
                dataType: "json",
                data: {id: datum.id},
                success: function (result) {
                    //console.log(result.master_motor[0].nama_motor);
                    $('#product_id').val(result.product[0].id);
                    $('#product_name').val(result.product[0].product_list_name);
                },
                async: false
            });
        });
    });
    
    function detailStockBtn(kode){
            $('#listDetail').DataTable({
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('stock_management/get_stock_detail') ?>",
                    "type": "POST",
                    "data":{kode:kode}
                },
                "fnDrawCallback" : function(data,item) {
                    $("#modalDetail").modal('show');
                },
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                        //"className": 'select-checkbox',
                    }
                ],
                "bDestroy": true,
            });
        }
</script>