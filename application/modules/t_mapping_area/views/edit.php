<div class="row">
    <div class="col-lg-2">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo base_url($data_sales['photo_path']); ?>" />
            </span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> NIP </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data_sales['employee_nip']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data_sales['employee_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data_sales['employee_email']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup"><?php echo $data_sales['employee_phone']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Gender </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="login"><?php echo ($data_sales['employee_gender'] == "M" ? "Male" : "Female"); ?></span>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <a href="<?php echo base_url('mapping-area'); ?>" class="btn btn-warning btn-sm">Done</a>
        </div>
    </div>
    <div class="col-lg-6">
        
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-5">
        <div id="available_area"></div>
    </div>
    <div class="col-lg-2">
        <div style="margin-top: 100%;">
            <center>
                <button class="btn btn-default" id="area-add"> >> </button> <br>
                <button class="btn btn-default" id="area-remove"> << </button>
            </center>
        </div>
    </div>
    <div class="col-lg-5">
        <div id="current_area"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var idEmployee = <?php echo $data_sales['id'];?>;
        $("#available_area").tabulator({
            fitColumns: true,
            pagination: false,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"area_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getAvailableArea/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Sub Area Code", field: "subarea_code", sorter: "string", tooltip: true},
                {title: "Sub Area Name", field: "subarea_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#current_area").tabulator({
            fitColumns: true,
            pagination: false,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"area_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getCurrentArea/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Sub Area Code", field: "subarea_code", sorter: "string", tooltip: true},
                {title: "Sub Area Name", field: "subarea_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#area-add").click(function(e){
            e.preventDefault();
            var availableArea = $("#available_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/insertArea');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: availableArea }
            }).done(function() {
                console.log( "success" );
                $("#current_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentArea/'.$data_sales['id']); ?>");
                $("#available_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableArea/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });;
        });
        
        $("#area-remove").click(function(e){
            e.preventDefault();
            var currentArea = $("#current_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/removeArea');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: currentArea }
            }).done(function() {
                console.log( "success" );
                $("#current_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentArea/'.$data_sales['id']); ?>");
                $("#available_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableArea/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });;
        });
    });
</script>
