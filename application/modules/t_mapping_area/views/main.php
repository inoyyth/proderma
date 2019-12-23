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
                                    <label class="small">Employee Name</label>
                                    <input type="text" class="form-control input-sm" id="search-employee-name" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Position</label>
                                    <input type="text" class="form-control input-sm" id="search-position" onkeypress="return runFilter(event)">
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
		<a href="<?php echo base_url('t_mapping_area/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
        <!--<a href="#" type="button" id="btn-view" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> View</a>-->
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
            ajaxURL: "<?php echo base_url('t_mapping_area/getListTable'); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "NIP", field: "employee_nip", sorter: "string", tooltip: true},
                {title: "Name", field: "employee_name", sorter: "string", tooltip: true},
                {title: "Position", field: "jabatan", sorter: "string", tooltip: true},
				{title: "Branch", field: "branch_name", sorter: "string", tooltip: true}
             ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>mapping-area-edit-' + data[0]['id'] + '.html');
                    $('#btn-view').attr('href', '<?php echo site_url(); ?>mapping-area-view-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-view').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>mapping-area-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        var params = {
            employee_name: $('#search-employee-name').val(),
            jabatan: $('#search-position').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('t_mapping_area/getListTable'); ?>", params);
    }

    function runFilter(e) {
        if (e.keyCode == 13) {
            filterTable();
            return false;
        }
    }
</script>