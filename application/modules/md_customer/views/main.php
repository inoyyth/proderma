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
                                    <label class="small">Group Product</label>
                                    <select class="form-control input-sm" id="search-group-product" onchange="return filterTable()">
                                        <option value=""></option>
                                        <?php foreach($group_customer_product as $v): ?>
                                        <option value="<?php echo $v['id'];?>"><?php echo $v['group_customer_product'];?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Status</label>
                                    <select class="form-control input-sm" id="search-status-customer" onchange="return filterTable()">
                                        <option value=""></option>
                                        <?php foreach($status_list_customer as $v): ?>
                                        <option value="<?php echo $v['id'];?>"><?php echo $v['status_list_customer'];?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Code</label>
                                    <input type="text" class="form-control input-sm" id="search-code" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Name</label>
                                    <input type="text" class="form-control input-sm" id="search-name" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Clinic</label>
                                    <input type="text" class="form-control input-sm" id="search-clinic" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Address</label>
                                    <input type="text" class="form-control input-sm" id="search-address" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group" id="remote-province">
                                    <label class="small">Province</label>
                                    <input type="hidden" id="search-province">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group" id="remote-city">
                                    <label class="small">City</label>
                                    <input type="hidden" id="search-city">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                               <div class="form-group" id="remote-district">
                                    <label class="small">District</label>
                                    <input type="hidden" id="search-district">
                                    <input class="typeahead form-control input-sm" style="text-transform: capitalize;" type="text" onkeypress="return runFilter(event)">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 2px;">
        <a href="<?php echo site_url('customer-add'); ?>" type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New Customer</a>
        <a href="#" type="button" id="btn-edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
        <a href="#" type="button" id="btn-delete" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus data?');"><i class="fa fa-remove"></i> Delete</a>
		<a href="<?php echo base_url('md_customer/print_excel');?>" type="button" id="btn-excel" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Excel</a>
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
              url: '<?php echo base_url('md_customer/getProvinceList?query=%QUERY');?>',
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
              url: '<?php echo base_url('md_customer/getCityList?query=%QUERY');?>',
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
              url: '<?php echo base_url('md_customer/getDistrictList?query=%QUERY');?>',
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
            ajaxURL: "<?php echo base_url('md_customer/getListTable'); ?>", //ajax URL
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
				{title: "Branch", field: "branch_name", sorter: "string", tooltip: true},
                {title: "Phone", field: "customer_phone", sorter: "string", tooltip: true},
                {title: "Group Product", field: "group_customer_product", sorter: "string", tooltip: true},
                {title: "Status", field: "status_list_customer", sorter: "string", tooltip: true}
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                console.log(data);
                if (data.length > 0) {
                    $('#btn-edit').attr('href', '<?php echo site_url(); ?>customer-edit-' + data[0]['id'] + '.html');
                    $('#btn-delete').attr('href', '<?php echo site_url(); ?>customer-delete-' + data[0]['id'] + '.html');
                } else {
                    $('#btn-edit').attr('href', '#');
                    $('#btn-delete').attr('href', '#');
                }
            },
            rowDblClick:function(e, row){
                location.replace('<?php echo site_url(); ?>customer-edit-' + row + '.html');
            },
        });
    });

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        $("#search-province,#search-city,#search-district").val('');
        filterTable();
    }

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
            group_customer: $('#search-group-product').val(),
            status_list: $('#search-status-customer').val(),
            code: $('#search-code').val(),
            name: $('#search-name').val(),
            clinic: $('#search-clinic').val(),
            address: $('#search-address').val(),
            province: $('#search-province').val(),
            city: $('#search-city').val(),
            district: $('#search-district').val(),
        };

        $("#example-table").tabulator("setData", "<?php echo base_url('md_customer/getListTable'); ?>", params);
    }
</script>