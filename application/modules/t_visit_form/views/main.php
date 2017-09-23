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
                                    <label class="small">Code</label>
                                    <input type="text" class="form-control input-sm" id="search-code">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Subject</label>
                                    <input type="text" class="form-control input-sm" id="search-subject">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Supervisor</label>
                                    <input type="text" class="form-control input-sm" id="search-sales">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Attenndence</label>
                                    <input type="text" class="form-control input-sm" id="search-attendence">
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
        <a href="<?php echo site_url('visit-form-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
		<a href="<?php echo base_url('t_visit_form/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
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
            ajaxURL: "<?php echo base_url('t_visit_form/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Code", field: "visit_form_code", sorter: "string", tooltip: true},
                {title: "Subject", field: "visit_form_subject", sorter: "string", tooltip: true},
                {title: "Attendence", field: "customer_name", sorter: "string", tooltip: true},
                {title: "Supervisor", field: "employee_name", sorter: "string", tooltip: true},
                {title: "Activity", field: "activity_name", sorter: "string", tooltip: true},
				{title: "Start", field: "visit_form_start_date", sorter: "string", tooltip: true},
				{title: "End", field: "visit_form_end_date", sorter: "string", tooltip: true},
				{title: "Activity Progress", field: "visit_form_progress", sorter: "string", tooltip: true}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>visit-form-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>visit-form-delete-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>visit-form-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        $('#btn-excel').attr('href', '<?php echo base_url();?>t_visit_form/print_excel?start_date=' + $('#search-start').val() + '&end_date=' + $('#search-end').val() + '&supervisor=' + $('#search-sales').val());
        var params = {
            code: $('#search-code').val(),
            sales: $('#search-sales').val(),
            subject: $('#search-subject').val(),
            attendence: $('#search-attendence').val(),
			start: $('#search-start').val(),
			end: $('#search-end').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_visit_form/getListTable'); ?>", params);
    }
</script>