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
        <div class="row" style="padding-left: 24px;">
            <a href="<?php echo base_url('mapping-area'); ?>" class="btn btn-warning btn-sm">Save</a>
        </div>
    </div>
    <div class="col-lg-6">
        
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-5">
        <div class="row" style="margin-bottom: 10px;"> 
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" id="search-available-txt" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-sm" id="search-available-btn" type="button">Go!</button>
                    </span>
              </div><!-- /input-group -->
            </div>
        </div>
        <div id="available_area"></div>
    </div>
    <div class="col-lg-2">
        <div style="margin-top: 100%;">
            <center>
                <button class="btn btn-default" id="area-add"> >> </button><br>
                <button class="btn btn-default" id="area-remove"> << </button>
            </center>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="row" style="margin-bottom: 10px;"> 
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" id="search-current-txt" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-sm" id="search-current-btn" type="button">Go!</button>
                    </span>
              </div><!-- /input-group -->
            </div>
        </div>
        <div id="current_area"></div>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-lg-5">
        <div class="row" style="margin-bottom: 10px;"> 
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" id="search-available-masterlist-txt" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-sm" id="search-available-masterlist-btn" type="button">Go!</button>
                    </span>
              </div><!-- /input-group -->
            </div>
        </div>
        <div id="available_masterlist_area"></div>
    </div>
    <div class="col-lg-2">
        <div style="margin-top: 100%;">
            <center>
                <button class="btn btn-default" id="area-masterlist-add"> >> </button><br>
                <button class="btn btn-default" id="area-masterlist-remove"> << </button>
            </center>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="row" style="margin-bottom: 10px;"> 
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" id="search-current-masterlist-txt" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-sm" id="search-current-masterlist-btn" type="button">Go!</button>
                    </span>
              </div><!-- /input-group -->
            </div>
        </div>
        <div id="current_masterlist_area"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var idEmployee = <?php echo $data_sales['id'];?>;
        $("#available_area").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 2500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"subarea_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getAvailableCustomer/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Customer Code", field: "customer_code", sorter: "string", tooltip: true},
                {title: "Customer Name", field: "customer_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#search-available-btn").click(function(){
            var params = {
                query: $('#search-available-txt').val(),
            };

            $("#available_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomer/'.$data_sales['id']); ?>", params);
        });
        
        $("#current_area").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 2500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"subarea_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getCurrentCustomer/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Customer Code", field: "customer_code", sorter: "string", tooltip: true},
                {title: "CUstomer Name", field: "customer_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#search-current-btn").click(function(){
            var params = {
                query: $('#search-current-txt').val(),
            };

            $("#current_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomer/'.$data_sales['id']); ?>", params);
        });
        
        $("#area-add").click(function(e){
            e.preventDefault();
            var availableArea = $("#available_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/insertCustomer');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: availableArea }
            }).done(function() {
                console.log( "success" );
                $("#current_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomer/'.$data_sales['id']); ?>");
                $("#available_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomer/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
        
        $("#area-remove").click(function(e){
            e.preventDefault();
            var currentArea = $("#current_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/removeCustomer');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: currentArea }
            }).done(function() {
                console.log( "success" );
                $("#current_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomer/'.$data_sales['id']); ?>");
                $("#available_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomer/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
        
        $("#available_masterlist_area").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 2500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"subarea_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getAvailableCustomerList/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Customer List Code", field: "customer_code", sorter: "string", tooltip: true},
                {title: "Customer List Name", field: "customer_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#search-available-masterlist-btn").click(function(){
            var params = {
                query: $('#search-available-masterlist-txt').val(),
            };

            $("#available_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomerList/'.$data_sales['id']); ?>", params);
        });
        
        $("#current_masterlist_area").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 2500,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            groupBy:"subarea_name",
            ajaxURL: "<?php echo base_url('t_mapping_area/getCurrentCustomerList/'.$data_sales['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Customer Code", field: "customer_code", sorter: "string", tooltip: true},
                {title: "CUstomer Name", field: "customer_name", sorter: "string", tooltip: true},
             ],
            selectable: 100
        });
        
        $("#search-current-masterlist-btn").click(function(){
            var params = {
                query: $('#search-current-masterlist-txt').val(),
            };

            $("#current_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomerList/'.$data_sales['id']); ?>", params);
        });
        
        $("#area-masterlist-add").click(function(e){
            e.preventDefault();
            var availableArea = $("#available_masterlist_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/insertCustomerList');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: availableArea }
            }).done(function() {
                console.log( "success" );
                $("#current_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomerList/'.$data_sales['id']); ?>");
                $("#available_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomerList/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
        
        $("#area-masterlist-remove").click(function(e){
            e.preventDefault();
            var currentArea = $("#current_masterlist_area").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_area/removeCustomerList');?>",
                type: "POST",
                dataType: "json",
                cache:false,
                data: { id_employee : idEmployee, arrayData: currentArea }
            }).done(function() {
                console.log( "success" );
                $("#current_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getCurrentCustomerList/'.$data_sales['id']); ?>");
                $("#available_masterlist_area").tabulator("setData", "<?php echo base_url('t_mapping_area/getAvailableCustomerList/'.$data_sales['id']); ?>");
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
    });
</script>
