<div class="row">
    <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
        <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title smaller">Filter Panels</h6>
                <div class="widget-toolbar">
                    <button type="button" class="btn btn-xs btn-success" onclick="filterTable();">Search</button>
                    <button type="button" class="btn btn-xs btn-warning" onclick="clearFilterTable();">Clear</button>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <form class="form-filter-table">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Product Code</label>
                                    <input type="text" class="form-control input-sm" id="search-code" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Product Name</label>
                                    <input type="text" class="form-control input-sm" id="search-name" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Product Price</label>
                                    <input type="text" class="form-control input-sm" id="search-price" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Category</label>
                                    <input type="text" class="form-control input-sm" id="search-category" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('master-product-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning btn-dsb"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger btn-dsb" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
        <a href="#" type="button" id="btn-detail" class="btn btn-xs btn-success btn-dsb"><i class="fa fa-file"></i> Detail</a>
        <a href="<?php echo base_url('md_product/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
		var sessGlobal = "<?php echo $this->sessionGlobal['super_admin'];?>";
		console.log(sessGlobal);
		$(".btn-dsb").attr('disabled',true).css('pointer-events','none');
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('md_product/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Product Code", field: "product_code", sorter: "string", tooltip: true},
                {title: "Product Name", field: "product_name", sorter: "string", tooltip: true},
                {title: "Product Category", field: "product_category", sorter: "string", tooltip: true},
                {title: "Product Price", field: "product_price", formatter: "money", sorter: "number"},
                {title: "Group", field: "group_product", sorter: "string"},
                {title: "Product Status", field: "status", sorter: "string"}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    if (sessGlobal === "1") {
                        if (data[0]['id_group_product'] == 2) {
                            $('#btn-edit').attr('href', '<?php echo site_url(); ?>master-product-edit-' + data[0]['id'] + '.html');
                            $('#btn-delete').attr('href', '<?php echo site_url(); ?>master-product-delete-' + data[0]['id'] + '.html');
                            $('#btn-detail').attr('href', '<?php echo site_url(); ?>master-product-detail-' + data[0]['id'] + '.html');
                            $(".btn-dsb").removeAttr('disabled',true).css('pointer-events','auto');
                        } else {
                            $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                            $('#btn-edit').attr('href', '#');
                            $('#btn-delete').attr('href', '#');
                            $("#btn-detail").removeAttr('disabled',true).css('pointer-events','auto');
                            $('#btn-detail').attr('href', '<?php echo site_url(); ?>master-product-detail-' + data[0]['id'] + '.html');
                        }
                    } else if (sessGlobal === "2") {
                        if (data[0]['id_group_product'] == 2) {
                            $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                            $('#btn-edit').attr('href', '#');
                            $('#btn-delete').attr('href', '#');
                            $("#btn-detail").removeAttr('disabled',true).css('pointer-events','auto');
                            $('#btn-detail').attr('href', '<?php echo site_url(); ?>master-product-detail-' + data[0]['id'] + '.html');
                        } else {
                            $('#btn-edit').attr('href', '<?php echo site_url(); ?>master-product-edit-' + data[0]['id'] + '.html');
                            $('#btn-delete').attr('href', '<?php echo site_url(); ?>master-product-delete-' + data[0]['id'] + '.html');
                            $('#btn-detail').attr('href', '<?php echo site_url(); ?>master-product-detail-' + data[0]['id'] + '.html');
                            $(".btn-dsb").removeAttr('disabled',true).css('pointer-events','auto');
                        }
                    } else {
                        $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                        $('#btn-edit').attr('href', '#');
                        $('#btn-delete').attr('href', '#');
                        $("#btn-detail").removeAttr('disabled',true).css('pointer-events','auto');
                        $('#btn-detail').attr('href', '<?php echo site_url(); ?>master-product-detail-' + data[0]['id'] + '.html');
                    }
                } else {
                    $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                    $('#btn-detail').attr('href', '#');
                }
            },
            /*rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>master-product-edit-' + row + '.html');
            },*/
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        console.log('filter');
        var params = {
            code: $('#search-code').val(),
            name: $('#search-name').val(),
            price: $('#search-price').val(),
            category: $('#search-category').val()
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_product/getListTable'); ?>", params);
    }

    function runFilter(e) {
        if (e.keyCode == 13) {
            filterTable();
            return false;
        }
    }
</script>