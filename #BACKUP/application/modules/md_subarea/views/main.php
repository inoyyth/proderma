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
                                <label class="small">Area Code / Name</label>
                                <select class="form-control input-sm" id="search-area-code">
                                    <option value="" selected="true"> - </option>
                                    <?php foreach($area as $vArea) { ?>
                                    <option value="<?php echo $vArea['id'];?>"><?php echo $vArea['area_code'] . " / " . $vArea['area_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="small">Subarea Code</label>
                                <input type="text" class="form-control input-sm" id="search-subarea-code">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="small">Subarea Name</label>
                                <input type="text" class="form-control input-sm" id="search-subarea-name">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="padding-bottom: 2px;">
    <a href="<?php echo site_url('master-subarea-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</a>
    <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
    <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
    <a href="<?php echo base_url('md_subarea/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
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
        ajaxURL: "<?php echo base_url('md_subarea/getListTable'); ?>", //ajax URL
        //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
        columns: [//Define Table Columns
            {formatter: "rownum", align: "center", width: 40},
            {title: "Subarea Code", field: "subarea_code", sorter: "string", tooltip: true},
            {title: "Subarea Name", field: "subarea_name", sorter: "string", tooltip: true},
            {title: "Subarea Description", field: "subarea_description", sorter: "string", tooltip: true},
            {title: "Area Name", field: "area_name", sorter: "string", tooltip: true},
            {title: "Status", field: "status", sorter: "string", tooltip: true}
        ],
        selectable: 1,
        rowSelectionChanged: function (data, rows) {
            console.log(data);
            if (data.length > 0) {
                $('#btn-edit').attr('href', '<?php echo site_url(); ?>master-subarea-edit-' + data[0]['id'] + '.html');
                $('#btn-delete').attr('href', '<?php echo site_url(); ?>master-subarea-delete-' + data[0]['id'] + '.html');
            } else {
                $('#btn-edit').attr('href', '#');
                $('#btn-delete').attr('href', '#');
            }
        },
        rowDblClick:function(e, row){
            location.replace('<?php echo site_url(); ?>master-subarea-edit-' + row + '.html');
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
        area_code: $('#search-area-code').val(),
        subarea_code: $('#search-subarea-code').val(),
        subarea_name: $('#search-subarea-name').val()
    };

    $("#example-table").tabulator("setData", "<?php echo base_url('md_subarea/getListTable'); ?>", params);
}
</script>