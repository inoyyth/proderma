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
                                    <label class="small">SO Code</label>
                                    <input type="text" class="form-control input-sm" id="search-so-code">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">DO Code</label>
                                    <input type="text" class="form-control input-sm" id="search-do-code">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Invoice Code</label>
                                    <input type="text" class="form-control input-sm" id="search-invoice-code">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('invoice-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Detail</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>
<div id="modal-mapping"></div>
<script>
    $(document).ready(function () {
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_invoice/getListTable'); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Invoice Code", field: "invoice_code", sorter: "string", tooltip: true},
                {title: "DO Code", field: "do_code", sorter: "string", tooltip: true},
                {title: "SO Code", field: "so_code", sorter: "string", tooltip: true},
                {title: "Date", field: "invoice_date", sorter: "string", tooltip: true},
             ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>invoice-detail-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>invoice-delete-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-view').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>invoice-detail-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        var params = {
            so_code: $('#search-so-code').val(),
            do_code: $('#search-do-code').val(),
            invoice_code: $('#search-invoice-code').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_invoice/getListTable'); ?>", params);
    }
</script>