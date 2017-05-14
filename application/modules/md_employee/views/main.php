<div class="row">
    <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
        <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title smaller">Filter Panels</h6>
                <div class="widget-toolbar">
                    <button type="button" class="btn btn-xs btn-success" onclick="filterTable();">Filter</button>
                    <button type="button" class="btn btn-xs btn-warning" onclick="clearFilterTable();">Clear</button>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <form class="form-filter-table">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Nip</label>
                                    <input type="text" class="form-control input-sm" id="search-nip">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Name</label>
                                    <input type="text" class="form-control input-sm" id="search-name">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Position</label>
                                    <input type="text" class="form-control input-sm" id="search-position">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Email</label>
                                    <input type="text" class="form-control input-sm" id="search-email">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Phone</label>
                                    <input type="text" class="form-control input-sm" id="search-phone">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Gender</label>
                                    <select class="form-control input-sm" id="search-gender">
                                        <option value=""></option>
                                        <option value="F">Female</option>
                                        <option value="M">Male</option>
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
        <a href="<?php echo site_url('master-employee-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
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
            ajaxURL: "<?php echo base_url('md_employee/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "NIP", field: "employee_nip", sorter: "string", tooltip: true},
                {title: "Name", field: "employee_name", sorter: "string", tooltip: true},
                {title: "Position", field: "jabatan", sorter: "string"},
                {title: "Email", field: "employee_email", sorter: "string"},
                {title: "Phone", field: "employee_phone", sorter: "string"},
                {title: "Gender", field: "employee_gender", sorter: "string"},
                {title: "Status", field: "status", sorter: "string"}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>master-employee-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>master-employee-delete-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                }
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
            nip: $('#search-nip').val(),
            nama: $('#search-name').val(),
            jabatan: $('#search-position').val(),
            email: $('#search-email').val(),
            phone: $('#search-phone').val(),
            gender: $('#search-gender').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_employee/getListTable'); ?>", params);
    }
</script>