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
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="small">Username</label>
                                    <input type="text" class="form-control input-sm" id="username" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="small">Full Name</label>
                                    <input type="text" class="form-control input-sm" id="nama_lengkap" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="small">Last Login</label>
                                    <input type="text" class="form-control input-sm" id="last_login" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-3">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('user-management-add');?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning btn-dsb"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger btn-dsb" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
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
            ajaxURL: "<?php echo base_url('account/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Username", field: "username", sorter: "string", tooltip: true},
                {title: "Full Name", field: "nama_lengkap", sorter: "string", tooltip: true},
                {title: "Admin Status", field: "superadmin_txt", sorter: "string", tooltip: true},
                {title: "Office", field: "branch_name", sorter: "string", tooltip: true},
                {title: "Last Login", field: "last_login", sorter: "string"},
                {title: "Status", field: "status", sorter: "string"},
            ],
            selectable:1,
            rowSelectionChanged:function(data, rows){
                console.log(data);
                if(data.length > 0) {
                    $('#btn-edit').attr('href','<?php echo site_url();?>user-management-edit-'+data[0]['id']+'.html');
                    $('#btn-delete').attr('href','<?php echo site_url();?>user-management-delete-'+data[0]['id']+'.html');
                    $(".btn-dsb").removeAttr('disabled',true).css('pointer-events','auto');
                    if(data[0]['super_admin'] === "2" ) {
                        $("#btn-delete").attr('disabled',true).css('pointer-events','none');
                    }
                } else {
                    $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                    $('#btn-edit').attr('href','#');
                    $('#btn-delete').attr('href','#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>user-management-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function runFilter(e) {
        if (e.keyCode == 13) {
            filterTable();
            return false;
        }
    }

    function filterTable() {
        console.log('filter');
        var params = {
            username: $('#username').val(),
            nama_lengkap: $('#nama_lengkap').val(),
            last_login: $('#last_login').val()
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('account/getListTable'); ?>", params);
    }
</script>