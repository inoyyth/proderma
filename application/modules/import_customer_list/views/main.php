<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Upload Form</h4>
            </div>
            <div class="widget-body">
                <form method="post" name="frmGroupUser" id="frmGroupUser" enctype="multipart/form-data">
                    <div class="col-xs-12" style="margin-top: 5px;">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input multiple type="file" name="excel_file" id="id-input-file-3" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 10px;">
                        <button type="submit" id="myButton" data-loading-text="Loading..." class="btn btn-primary btn-sm">Generate</button> 
                        <button type="button" class="btn btn-warning btn-sm" id="cancel-form">Cancel</button>
                        <a href="<?php echo site_url('import-customer-list-template'); ?>" class="btn btn-success btn-sm">[Download Template]</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div style="padding: 5px;">
            <button id="select-all" class="btn btn-warning btn-sm">Select All</button>
            <button id="deselect-all" class="btn btn-warning btn-sm">Deselect All</button>
            <button id="delete-list" class="btn btn-warning btn-sm">Delete</button>
            <button id="save-list" class="btn btn-warning btn-sm">Save</button>
        </div>
        <div id="example-table"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: false, //| true | large
            whitelist: 'xls|xlsx', //|jpg|jpeg
            blacklist: 'exe|php|zip'
                    //,icon_remove:null//set null, to hide remove/reset button
                    /**,before_change:function(files, dropped) {
                     //Check an example below
                     //or examples/file-upload.html
                     return true;
                     }*/
                    /**,before_remove : function() {
                     return true;
                     }*/
            ,
            preview_error: function (filename, error_code) {
                console.log(error_code);
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function () {
            //console.log(getFileExtension1($(this).data('ace_input_files')[0]['name']));
            var extention = getFileExtension1($(this).data('ace_input_files')[0]['name']);
            if (extention === "xlsx" || extention === "xls") {
                return true;
            } else {
                alert('file extention false !!!');
                $('#id-input-file-3').ace_file_input('reset_input');
                return false;
            }
        }).on('file.error.ace', function (e, info) {
            console.log(e);
        }).on('file.preview.ace', function (e, info) {
            //console.log(info);
            e.preventDefault();//to prevent preview
        });

        $("#frmGroupUser").on("submit", function (event) {
            var $btn = $("#myButton").button('loading');
            event.preventDefault();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                url: "<?php echo base_url('import-customer-list-upload'); ?>",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                //dataType : "json",
                success: function (e) {
                    $btn.button('reset');
                    $('#id-input-file-3').ace_file_input('reset_input');
                    $("#example-table").tabulator("setData", "<?php echo base_url('import_customer_list/getListTable'); ?>");
                    //table.ajax.reload();
                },
                error: function (e) {
                    $('#id-input-file-3').ace_file_input('reset_input');
                    $btn.button('reset');
                    alert('fail');
                }
            });
        });

        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            selectable: true, //make rows selectable
            height: "320px", // set height of table (optional),
            pagination: "remote",
            paginationSize: 50,
            fitColumns: true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('import_customer_list/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Name", field: "customer_name", sorter: "string", tooltip: true},
                {title: "Specialis", field: "customer_specialis", sorter: "string", tooltip: true},
                {title: "Clinic", field: "customer_clinic", sorter: "string", tooltip: true},
                {title: "Address", field: "customer_address", sorter: "string", tooltip: true},
                {title: "Province", field: "province_name", sorter: "string", tooltip: true},
                {title: "City", field: "city_name", sorter: "string", tooltip: true},
                {title: "District", field: "district_name", sorter: "string", tooltip: true},
                {title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Subarea", field: "subarea_name", sorter: "string", tooltip: true},
                {title: "Branch", field: "branch_name", sorter: "string", tooltip: true},
                
            ],
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    //$('#btn-edit').attr('href', '<?php echo site_url(); ?>employee-level-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>employee-level-delete-' + data[0]['id'] + '.html');
                } else {
                    //$('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                }
            },
        });

        //select row on "select all" button click
        $("#select-all").click(function () {
            $("#example-table").tabulator("selectRow");
        });

        //deselect row on "deselect all" button click
        $("#deselect-all").click(function () {
            $("#example-table").tabulator("deselectRow");
        });
        
        $("#delete-list").click(function(){
            var selectedData = $("#example-table").tabulator("getSelectedData");
            var json = JSON.stringify(selectedData); 
            $.ajax({
                url: "<?php echo base_url('import_customer_list/deleteListTable');?>",
                type: "post",
                data: {"data":json},
                cache: false,
                ////contentType: false,
                //processData: false,
                dataType : "json",
                success: function (e) {
                    if(e.code == 200){
                        $("#example-table").tabulator("setData", "<?php echo base_url('import_customer_list/getListTable'); ?>");
                    } else {
                        alert(e.message);
                    }
                },
                error: function (e) {
                    //alert('fail');
                }
            });
        });
        
        $("#save-list").click(function(){
            var selectedData = $("#example-table").tabulator("getSelectedData");
            var json = JSON.stringify(selectedData); 
            $.ajax({
                url: "<?php echo base_url('import_customer_list/saveListTable');?>",
                type: "post",
                data: {"data":json},
                cache: false,
                ////contentType: false,
                //processData: false,
                dataType : "json",
                success: function (e) {
                    if(e.code == 200){
                        $("#example-table").tabulator("setData", "<?php echo base_url('import_customer_list/getListTable'); ?>");
                    } else {
                        alert(e.message);
                    }
                },
                error: function (e) {
                    //alert('fail');
                }
            });
        });

    });

    function getFileExtension1(filename) {
        return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
    }
</script>