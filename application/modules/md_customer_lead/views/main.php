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
                    <form class="form-filter-table">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Source Lead</label>
                                    <select class="form-control input-sm" id="search-source-lead">
                                        <option value=""></option>
                                        <?php foreach($source_lead_customer as $v): ?>
                                        <option value="<?php echo $v['id'];?>"><?php echo $v['source_lead_customer'];?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Status Lead</label>
                                    <select class="form-control input-sm" id="search-status-lead">
                                        <option value=""></option>
                                        <?php foreach($status_lead_customer as $v): ?>
                                        <option value="<?php echo $v['id'];?>"><?php echo $v['status_lead_customer'];?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Code</label>
                                    <input type="text" class="form-control input-sm" id="search-code">
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
                                    <label class="small">Clinic</label>
                                    <input type="text" class="form-control input-sm" id="search-clinic">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Address</label>
                                    <input type="text" class="form-control input-sm" id="search-address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group" id="remote-province">
                                    <label class="small">Province</label>
                                    <input type="hidden" id="search-province">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group" id="remote-city">
                                    <label class="small">City</label>
                                    <input type="hidden" id="search-city">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text">
                                </div>
                            </div>
                            <div class="col-lg-2">
                               <div class="form-group" id="remote-district">
                                    <label class="small">District</label>
                                    <input type="hidden" id="search-district">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('lead-customer-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New Customer</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
        <a href="#" type="button" id="btn-priority" class="btn btn-xs btn-default"><i class="fa fa-info-circle"></i> Set Priority</a>
        <a href="#" type="button" id="btn-undo-priority" class="btn btn-xs btn-default"><i class="fa fa-info-circle"></i> Undo Priority</a>
        <a href="#" type="button" id="btn-set-customer" class="btn btn-xs btn-default"><i class="fa fa-info-circle"></i> Set As Customer</a>
    </div>
    <div class="col-lg-12">
        <div id="example-table"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //autocomplete
        var searchDataProvince = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
              url: '<?php echo base_url('md_customer_lead/getProvinceList?query=%QUERY');?>',
              wildcard: '%QUERY'
            }
        });

        $('#remote-province .typeahead').typeahead(null, {
          name: 'province_name',
          display: 'province_name',
          source: searchDataProvince,
          minLength: 3,
          highlight: true,
          limit: 10
        });
        
        $('#remote-province .typeahead').bind('typeahead:selected', function(obj, datum, name) {
            $("#search-province").val(datum.province_id);
        });
        
        var searchDataCity = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
              url: '<?php echo base_url('md_customer_lead/getCityList?query=%QUERY');?>',
              wildcard: '%QUERY'
            }
        });

        $('#remote-city .typeahead').typeahead(null, {
          name: 'city_name',
          display: 'city_name',
          source: searchDataCity,
          minLength: 3,
          highlight: true,
          limit: 10
        });
        
        $('#remote-city .typeahead').bind('typeahead:selected', function(obj, datum, name) {
            $("#search-city").val(datum.city_id);
        });
        
        var searchDataDistrict = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
              url: '<?php echo base_url('md_customer_lead/getDistrictList?query=%QUERY');?>',
              wildcard: '%QUERY'
            }
        });

        $('#remote-district .typeahead').typeahead(null, {
          name: 'district_name',
          display: 'district_name',
          source: searchDataDistrict,
          minLength: 3,
          highlight: true,
          limit: 10
        });
        
        $('#remote-district .typeahead').bind('typeahead:selected', function(obj, datum, name) {
            $("#search-district").val(datum.city_id);
        });
        
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('md_customer_lead/getListTable'); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40, frozen:true},
                {title: "Code", field: "customer_code", sorter: "string", tooltip: true, frozen:true},
                {title: "Name", field: "customer_name", sorter: "string", tooltip: true},
                {title: "Clinic", field: "customer_clinic", sorter: "string", tooltip: true},
                {title: "Province", field: "province_name", sorter: "string", tooltip: true},
                {title: "City", field: "city_name", sorter: "string", tooltip: true},
                {title: "District", field: "district_name", sorter: "string", tooltip: true},
                {title: "Address", field: "customer_address", sorter: "string", tooltip: true},
                {title: "Phone", field: "customer_phone", sorter: "string", tooltip: true},
                {title: "Source Lead", field: "source_lead_customer", sorter: "string", tooltip: true},
                {title: "Status Lead", field: "status_lead_customer", sorter: "string", tooltip: true},
                {title: "Priority Lead", field: "customer_as_priority", align:"center", sorter: "string", editable:true, formatter:"tickCross", editor:function(cell, value, data){
                        $("#example-table").tabulator("updateRow", 1, {id:1, name:"bob", gender:"male"});
                    },
                }
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>lead-customer-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>lead-customer-delete-' + data[0]['id'] + '.html');
                    $('#btn-priority').attr('href', '<?php echo site_url(); ?>lead-customer-set-priority-' + data[0]['id'] + '.html');
                    $('#btn-undo-priority').attr('href', '<?php echo site_url(); ?>lead-customer-undo-priority-' + data[0]['id'] + '.html');
                    $('#btn-set-customer').attr('href', '<?php echo site_url(); ?>md_customer_lead/setAsPriority/' + data[0]['id']);
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                    $('#btn-priority').attr('href', '#');
                    $('#btn-undo-priority').attr('href', '#');
                    $('#btn-set-customer').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>lead-customer-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        $("#search-province,#search-city,#search-district").val('');
        filterTable();
    }

    function filterTable() {
        var params = {
            source_lead: $('#search-source-lead').val(),
            status_lead: $('#search-status-lead').val(),
            code: $('#search-code').val(),
            name: $('#search-name').val(),
            clinic: $('#search-clinic').val(),
            address: $('#search-address').val(),
            province: $('#search-province').val(),
            city: $('#search-city').val(),
            district: $('#search-district').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_customer_lead/getListTable'); ?>", params);
    }
    
    $('#btn-priority,#btn-undo-priority').click(function() {
        var dt = $(this);
        var url = dt[0].href;
        console.log(url);
        if(url === "<?php echo site_url('lead-customer');?>#"){
            alert('Silahkan pilih ada yang akan di update');
            return false;
        } else {
            $.ajax({
               url: url,
               type: 'get',
               success: function (){
                   filterTable();
               }
            });
        }
        
        return false;
    });
    
    $('#btn-set-customer').click(function() {
        var dt = $(this);
        var url = dt[0].href;
        console.log(url);
        if(url === "<?php echo site_url('lead-customer');?>#"){
            alert('Silahkan pilih ada yang akan di update');
            return false;
        } else {
            $.ajax({
               url: url,
               type: 'get',
               success: function (){
                   filterTable();
               }
            });
        }
        
        return false;
    });
</script>