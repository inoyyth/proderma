<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/css/highcharts.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/plugin/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css" />
<div class="row">
    <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
        <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <form class="form-filter-table">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Employee</label><br>
                                    <input type="text" id="text-employee" readonly="true" data-role="tagsinput" class="bootstrap-tagsinput form-control input-sm">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Monthly</label>
                                    <select class="form-control input-sm" placeholder="Month" id="search-month">
                                        <option value="" selected disabled="true"> -Select Month- </option>
                                        <?php
                                        $month = array(
                                            1 => 'January',
                                            2 => 'February',
                                            3 => 'March',
                                            4 => 'April',
                                            5 => 'May',
                                            6 => 'June',
                                            7 => 'July',
                                            8 => 'August',
                                            9 => 'September',
                                            10 => 'October',
                                            11 => 'November',
                                            12 => 'December'
                                        );
                                        foreach ($month as $k => $v) {
                                            echo "<option value='" . $k . "'>" . $v . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">&nbsp;</label>
                                    <select class="form-control input-sm" placeholder="Month" id="search-year">
                                        <option value="" selected disabled="true"> -Select Year- </option>
                                        <?php
                                        $year_now = (intval(date('Y')) - 5);
                                        for ($i = $year_now; $i <= ($year_now + 5); $i++) {
                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">&nbsp;</label>
                                    <button type="button" style="margin-top: 24px;" onclick="subReport(1);" class="btn btn-xs btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Yearly</label>
                                    <select class="form-control input-sm" placeholder="Month" id="search-year2">
                                        <option value="" selected disabled="true"> -Select Year- </option>
                                        <?php
                                        $year_now = (intval(date('Y')) - 5);
                                        for ($i = $year_now; $i <= ($year_now + 5); $i++) {
                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">&nbsp;</label>
                                    <button type="button" style="margin-top: 24px;" onclick="subReport(2);" class="btn btn-xs btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
		<div style="padding-bottom: 5px;">
			<input type="text" id="search-name"> <button class="btn btn-xs btn-primary" onclick="filterTable();">Search</button>
		</div>
        <div id="employee-table"></div>
    </div>
    <div class="col-lg-12">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div
    </div>
    <div class="col-lg-12" id="tabulator-content" style="margin-bottom: 50px;">
        <div id="example-table"></div>
    </div>
</div>
<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/modules/exporting.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/typeahead/dist/bloodhound.min.js"></script>
<script>
    $(document).ready(function () {
        $("#employee-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "200px", // set height of table (optional),
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
                {title: "Gender", field: "gender", sorter: "string"},
                {title: "Status", field: "status", sorter: "string"}
            ],
            selectable: 1,
            rowDblClick:function(e, row, data){
                $('#text-employee').tagsinput('add', data.employee_nip);
            },
        });
    });
	
	function filterTable() {
		console.log('filter');
		var params = {
			nama: $('#search-name').val()
		};
		$("#employee-table").tabulator("setData", "<?php echo base_url('md_employee/getListTable'); ?>", params);
	}

function subReport(tp) {
    if ($("#text-employee").val() === "") {
        alert('please select employee first');
        return false;
    }
    var dt = {};
    var tabulatorAjaxParams = {};
    if (tp === 1) {
        dt = {month: $("#search-month").val(), year: $("#search-year").val(), employee: $("#text-employee").val()};
        tabulatorAjaxParams = {month: $("#search-month").val(), year: $("#search-year").val(), employee: $("#text-employee").val()};
    } else {
        dt = {month: '', year: $("#search-year2").val(), employee: $("#text-employee").val()};
        tabulatorAjaxParams = {month: '', year: $("#search-year2").val(), employee: $("#text-employee").val()};
    }
    $.ajax({
        type: "POST",
        url: '<?php echo base_url('r_performance/getReport'); ?>',
        data: dt,
        success: function (i, data) {
            //console.log(data);
        },
        dataType: 'json'
    })
    .done(function (data) {
        var categories = $.map(data.category, function(value, index) {
            return [value];
        });
        var valueProduct = $.each(data.value, function(index, value) {
           return {name:value.product,data:value.total};
        }); 
        console.log(valueProduct);
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: data.title
            },
            subtitle: {
                text: data.subtitle
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Value'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: data.value
        });

        $("#example-table").remove();
        $("#tabulator-content").append('<div id="example-table"></div>');
        $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 200,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('r_performance/getListTable'); ?>", //ajax URL
            ajaxParams: tabulatorAjaxParams,
            groupBy: "kelompok",
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "SO.Code", field: "so_code", tooltip: true},
                {title: "SO.Date", field: "so_date"},
            ],
            selectable: 1,
        });
    });
}
</script>