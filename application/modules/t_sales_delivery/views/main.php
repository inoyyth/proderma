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
                                    <label class="small">Start Date</label>
                                    <input type="text" class="form-control input-sm date-picker" id="search-start">
                                </div>
                            </div>
							<div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">End Date</label>
                                    <input type="text" class="form-control input-sm date-picker" id="search-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('sales-delivery-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning btn-dsb"><i class="fa fa-edit"></i> Detail</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger btn-dsb" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
        <a href="#" type="button" id="btn-print" class="btn btn-xs btn-default btn-dsb"><i class="fa fa-print"></i> Print</a>
		<a href="<?php echo base_url('t_sales_delivery/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>
<div id="modal-mapping"></div>
<div class="modal fade bs-example-modal-lg" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="print-content"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".btn-dsb").attr('disabled',true);
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_sales_delivery/getListTable'); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "DO Code", field: "do_code", sorter: "string", tooltip: true},
                {title: "SO Code", field: "so_code", sorter: "string", tooltip: true},
				{title: "Customer Code", field: "customer_code", sorter: "string", tooltip: true},
				{title: "Customer Name", field: "customer_name", sorter: "string", tooltip: true},
                {title: "Date", field: "do_date", sorter: "string", tooltip: true},
				{title: "Progress", field: "do_sales_status", sorter: "string", tooltip: true},
             ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>sales-delivery-detail-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>sales-delivery-delete-' + data[0]['id'] + '.html');
                    $('#btn-print').attr('href', '<?php echo site_url(); ?>sales-delivery-print-' + data[0]['id'] + '.html');
                    $(".btn-dsb").removeAttr('disabled',true);
                } else {
                    $(".btn-dsb").attr('disabled',true);
                    $('#btn-edit').attr('href', '#');
                    $('#btn-view').attr('href', '#');
                    $('#btn-print').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>sales-delivery-detail-' + row + '.html');
            },
        });
    });

    $("#btn-print").click(function (event) {
        event.preventDefault();
        if($(this).attr('href') !== "") {
            $("#print-content").load($(this).attr('href')); 
            $('#modalPrint').modal('show');
        } else {
            alert('please select data');
        }
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
		$('#btn-excel').attr('href', '<?php echo base_url();?>t_sales_delivery/print_excel?start=' + $('#search-start').val() + '&end=' + $('#search-end').val());
        var params = {
            so_code: $('#search-so-code').val(),
            do_code: $('#search-do-code').val(),
			start: $('#search-start').val(),
			end: $('#search-end').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_sales_delivery/getListTable'); ?>", params);
    }
</script>