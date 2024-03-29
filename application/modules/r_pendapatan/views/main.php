<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/css/highcharts.css" />
<div class="row">
    <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
        <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <form class="form-filter-table">
                                <?php if($this->sessionGlobal['super_admin'] == "1") { ?>
                                <input type="hidden" id="search-branch" value="<?php echo $this->sessionGlobal['id_branch'];?>">
                                <?php } else { ?>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="small">Branch</label>
                                        <select class="form-control input-sm" placeholder="Month" id="search-branch">
                                            <option value="all" selected > -All- </option>
                                            <?php
                                            foreach ($branch as $kBranch => $vBranch) {
                                                echo "<option value='" . $vBranch['id']. "'>" . $vBranch['branch_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
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
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div
    </div>
    <div class="col-lg-12" id="tabulator-content" style="margin-bottom: 50px;">
        <div id="example-table"></div>
    </div>
</div>
<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/modules/exporting.js"></script>
<script>
    $(document).ready(function () {
        
    });
    
    function subReport(tp) {
        var dt = {};
        var tabulatorAjaxParams = {};
        if (tp === 1){
             dt = {branch: $("#search-branch").val(), month: $("#search-month").val(), year: $("#search-year").val()};
             tabulatorAjaxParams = {branch: $("#search-branch").val(), month: $("#search-month").val(), year: $("#search-year").val()};
        } else {
             dt = {branch: $("#search-branch").val(), month: '', year: $("#search-year2").val()};
             tabulatorAjaxParams = {branch: $("#search-branch").val(), month: '', year: $("#search-year2").val()};
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('r_pendapatan/getReport');?>',
            data: dt,
            success: function(i, data){
                console.log(data);
            },
            dataType: 'json'
        })
        .done(function (data){
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
                    categories: data.category
                },
                yAxis: {
                    allowDecimals: false,
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
                series: [{
                    name: 'Sales Order',
                    data: data.value
                }]
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
                ajaxURL: "<?php echo base_url('r_pendapatan/getListTable'); ?>", //ajax URL
                ajaxParams: tabulatorAjaxParams,
                groupBy:"kelompok",
                columns: [//Define Table Columns
                    {formatter: "rownum", align: "center", width: 40},
                    {title: "SO.Code", field: "so_code", tooltip: true},
                    {title: "Cust.Code", field: "customer_code", tooltip: true},
                    {title: "Cust.Name", field: "customer_name"},
                    {title: "SO.Date", field: "so_date"},
                    {title: "Total", field: "so_grand_total",formatter: 'money'}
                ],
                selectable: 1,
            });
        });
    }
</script>