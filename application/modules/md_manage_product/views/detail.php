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
                                    <label class="small">By Description</label>
                                    <input type="text" class="form-control input-sm" id="search-desc">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Transaction Status</label>
                                    <select class="form-control input-sm" id="search-status">
                                        <option value="" selected> All </option>
                                        <option value="I">In</option>
                                        <option value="O">Out</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('manage-product-add-'.$data['id']); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning btn-dsb"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger btn-dsb" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
        <a href="<?php echo base_url('md_manage_product/print_excel/'.$data['id']);?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
		var sessGlobal = "<?php echo $this->sessionGlobal['super_admin'];?>";
		$(".btn-dsb").attr('disabled',true).css('pointer-events','none');
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 50,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('md_manage_product/getDetailList/'.$data['id']); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Transaction Status", field: "status", sorter: "string", tooltip: true},
                {title: "QTY", field: "qty", sorter: "number", tooltip: false},
                {title: "Description", field: "description", sorter: "string", tooltip: true},
                {title: "Created Date", field: "sys_create_date", sorter: "string", tooltip: true},
                {title: "Update Date", field: "sys_update_date", sorter: "number"}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>manage-product-edit-<?php echo $data['id'];?>-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>manage-product-delete-<?php echo $data['id'];?>-' + data[0]['id'] + '.html');
                    $(".btn-dsb").removeAttr('disabled',true).css('pointer-events','auto');
                       
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                    $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>manage-product-list-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        console.log('filter');
        var params = {
            desc: $('#search-desc').val(),
            status: $('#search-status').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_manage_product/getDetailList/'.$data['id']); ?>", params);
    }
</script>