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
                                    <label class="small">SO.Code</label>
                                    <input type="text" class="form-control input-sm" id="search-so-code">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">DO.Code</label>
                                    <input type="text" class="form-control input-sm" id="search-do-code">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Invoice Code</label>
                                    <input type="text" class="form-control input-sm" id="search-invoice-code">
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
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
		<a href="<?php echo base_url('t_pay_duedate/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
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
            paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_pay_duedate/getListTable'); ?>",
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Invoice Code", field: "invoice_code", sorter: "string", tooltip: true},
				{title: "No Faktur", field: "no_faktur", sorter: "string", tooltip: true},
                {title: "DO.Code", field: "do_code", sorter: "string", tooltip: true},
                {title: "SO.Code", field: "so_code", sorter: "string", tooltip: true},
                {title: "Status", field: "pay_duedate_status", sorter: "string", tooltip: true},
                {title: "Due Date", field: "due_date", sorter: "string", tooltip: true},
                {title:"Severity", field:"color" ,formatter:"color", width:50},
                {title: "Description", field: "pay_duedate_description", sorter: "string", tooltip: true},
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>payment-due-date-edit-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>payment-due-date-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        $('#btn-excel').attr('href', '<?php echo base_url();?>t_pay_duedate/print_excel?start=' + $('#search-start').val() + '&end=' + $('#search-end').val());
        var params = {
            so_code: $('#search-so-code').val(),
            do_code: $('#search-do-code').val(),
            invoice_code: $('#search-invoice-code').val(),
			start: $('#search-start').val(),
			end: $('#search-end').val()
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_pay_duedate/getListTable'); ?>", params);
    }
</script>