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
                                    <label class="small">Province</label>
                                    <input type="text" class="form-control input-sm" id="search-province">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <button id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</button>
        <button type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
        <button type="button" id="btn-delete" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Delete</button>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Province</h4>
            </div>
            <form id="form-save" method="post" action="<?php echo base_url('md_location_manage/saveProvince');?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Province Name</label>
                        <input type="hidden" class="form-control" id="province_id" name="province_id">
                        <input type="text" id="province_name" required="true" name="province_name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
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
            ajaxURL: "<?php echo base_url('md_location_manage/getListProvince'); ?>", 
            initialSort:[
                {column:"province_name", dir:"asc"}, //sort by this first
            ],
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "ID", field: "id",width: 100, sorter: "string", tooltip: true},
                {title: "Name", field: "province_name", sorter: "string", tooltip: true}
            ],
            selectable: 1,
            rowDblClick:function(e, row){
                console.log(row);
                location.replace('<?php echo base_url(); ?>location-manage.html?province=' + row);
            },
        });
        
        $("#btn-add").click(function(){
            $("#form-save .form-control").val('');
            $(".modal").modal('show'); 
        });
        
        $("#btn-edit").click(function(){
            var selectedData = $("#example-table").tabulator("getSelectedData");
            if (selectedData.length > 0) {
                $("#province_id").val(selectedData[0]['id']);
                $("#province_name").val(selectedData[0]['province_name']);
                $(".modal").modal('show'); 
            } else {
                alert('Please Select Province!');
                return false;
            }
        });
        
        $("#btn-delete").click(function(){
            var selectedData = $("#example-table").tabulator("getSelectedData");
            if (selectedData.length > 0) {
                var ask = confirm("Want to delete? FYI: City And District with parent this province will delete too!");
                if (ask) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url('md_location_manage/deleteProvince');?>',
                        data: {id:selectedData[0]['id']},
                        success: function(result) {
                            $(".modal").modal('hide'); 
                            $("#example-table").tabulator("setData", "<?php echo base_url('md_location_manage/getListProvince'); ?>");
                        }
                    });
                } else {
                    return false;
                }
            } else {
                alert('Please Select City!');
                return false;
            }
        });
        
        $("#form-save").submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(result) {
                    $(".modal").modal('hide'); 
                    var params = {
                        province: $('#search-province').val(),
                    };
                    $("#example-table").tabulator("setData", "<?php echo base_url('md_location_manage/getListProvince'); ?>", params);
                }
            });
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        var params = {
            province: $('#search-province').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_location_manage/getListProvince'); ?>", params);
    }
</script>