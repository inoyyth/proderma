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
                                    <input type="text" id="text-employee" readonly="true" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">Date</label>
                                    <input class="form-control input-sm datepicker-month" id="datelog">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="small">&nbsp;</label>
                                    <button type="button" style="margin-top: 24px;" onclick="subReport();" class="btn btn-xs btn-primary btn-search">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div id="employee-table"></div>
    </div>
    <div class="col-lg-12">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>
<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/typeahead/dist/bloodhound.min.js"></script>
<script>
    $(document).ready(function () {
        $(".btn-search").attr('disabled',true);
        $("#datelog").val(formatDate(new Date()));
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
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $(".btn-search").removeAttr('disabled');
                    $('#text-employee').val(data[0]['employee_nip']);
                } else {
                    $(".btn-search").attr('disabled',true);
                    $('#text-employee').val("");
                }
            },
        });
    });

function subReport() {
    if($("#datelog").val() === "") {
        alert('Please Select Date');
        return false;
    }
    if ($("#text-employee").val() === "") {
        alert('please select employee first');
        return false;
    }
    var dt = {};
    dt = {date: $("#datelog").val(), employee: $("#text-employee").val()};
    
    $.ajax({
        type: "POST",
        url: '<?php echo base_url('log_battery/getReport'); ?>',
        data: dt,
        success: function (i, data) {
            console.log(data.value);
        },
        dataType: 'json'
    })
    .done(function (data) {
        var categories = $.map(data.category, function(value, index) {
            return [value];
        });
        Highcharts.chart('container', {
            chart: {
                type: 'area'
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
                },
                min: 0, max: 100
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                },
            },
            series: [data.value]
        });
    });
}
</script>