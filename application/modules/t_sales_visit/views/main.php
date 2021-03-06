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
                                    <label class="small">Customer</label>
                                    <input type="text" class="form-control input-sm" onkeypress="return runFilter(event)" id="search-customer-name">
                                </div>
                            </div>
                             <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Sales</label>
                                    <input type="text" class="form-control input-sm" onkeypress="return runFilter(event)" id="search-sales-name">
                                </div>
                            </div>
							<div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Start Date</label>
                                    <input type="text" class="form-control input-sm date-picker" onkeypress="return runFilter(event)" id="search-start">
                                </div>
                            </div>
							<div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">End Date</label>
                                    <input type="text" class="form-control input-sm date-picker" onkeypress="return runFilter(event)" id="search-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('ojt-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-detail" class="btn btn-xs btn-primary"><i class="fa fa-detail"></i> Detail</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
		<a href="<?php echo base_url('t_sales_visit/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 20,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_sales_visit/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Start Date", field: "sales_visit_date", sorter: "string", tooltip: true},
                {title: "End Date", field: "end_date", sorter: "string", tooltip: true},
                {title: "Customer", field: "customer_name", sorter: "string", tooltip: true},
                {title: "Sales", field: "employee_name", sorter: "string", tooltip: true},
                {title: "Order ID", field: "order_id", sorter: "string", tooltip: true},
                {title: "Activity", field: "objective", sorter: "string", tooltip: true},
				{title: "Related Code", field: "related_code", sorter: "string", tooltip: true},
                {title: "Progress", field: "sales_visit_progress", sorter: "string", tooltip: true},
                {title: "Created Date", field: "sys_create_date", sorter: "date", tooltip: true, align: "center", width: 170},
                {title: "Complete Date", field: "complete_date", sorter: "date", tooltip: true, align: "center", width: 170}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    $('#btn-detail').attr('href', '<?php echo site_url(); ?>ojt-detail-' + data[0]['id'] + '.html');
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>ojt-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>ojt-delete-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-detail').attr('href', '#');
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>ojt-detail-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
		$('#btn-excel').attr('href', '<?php echo base_url();?>t_sales_visit/print_excel?start_date=' + $('#search-start').val() + '&end_date=' + $('#search-end').val() + '&sales=' + $('#search-sales-name').val());
        var params = {
            customer_name: $('#search-customer-name').val(),
            sales_name: $('#search-sales-name').val(),
			start: $('#search-start').val(),
			end: $('#search-end').val()
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_sales_visit/getListTable'); ?>", params);
    }

    function runFilter(e) {
    if (e.keyCode == 13) {
        filterTable();
        return false;
    }
}
</script>