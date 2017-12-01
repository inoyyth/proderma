<?php
    if(isset($this->sessionGlobal['id_branch'])) {
        $branch = $this->sessionGlobal['id_branch'];
    } else {
        $branch = "all";
    }
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/css/highcharts.css" />
<div class="row">
    <div class="space-6"></div>

    <div class="col-sm-12 infobox-container">
        <div class="infobox infobox-green">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-cubes"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $product['total'];?></span>
                <div class="infobox-content">Product</div>
            </div>
        </div>

        <div class="infobox infobox-blue">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-users"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $customer['total'];?></span>
                <div class="infobox-content">Customer</div>
            </div>
        </div>

        <div class="infobox infobox-orange2">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-user-secret"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $sales['total'];?></span>
                <div class="infobox-content">Sales</div>
            </div>
        </div>

        <div class="space-6"></div>
        
        <!--<div class="infobox infobox-grey infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-shopping-bag"></i>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">Total SO</div>
                <div class="infobox-content"><?php echo $so['total'];?></div>
            </div>
        </div>

        <div class="infobox infobox-green infobox-small infobox-dark">
            <div class="infobox-progress">
                <div class="easy-pie-chart percentage" data-percent="61" data-size="39">
                    <span class="percent"><?php echo $so_total;?></span>%
                </div>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">SO</div>
                <div class="infobox-content">Completion</div>
            </div>
        </div>

        <div class="infobox infobox-grey infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-ambulance"></i>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">Due Date</div>
                <div class="infobox-content"><?php echo $due_date['total'];?></div>
            </div>
        </div>
    </div>-->

    <div class="vspace-12-sm"></div>
    <div class="col-lg-12" id="area-chart">
        <div class="col-lg-6">
            <div id="container-so-1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="col-lg-6">
            <div id="container-income-1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
    <!--<div class="col-sm-5">
        <div class="widget-box">
            <div class="widget-header widget-header-flat widget-header-small">
                <h5 class="widget-title">
                    <i class="ace-icon fa fa-signal"></i>
                    Mapping Area
                </h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div id="container"></div>

                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
        </div><!-- /.widget-box -->
    <!--</div><!-- /.col -->
</div><!-- /.row -->

<div class="hr hr32 hr-dotted"></div>

<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/highcharts.js"></script>
<script>
$(document).ready(function () {
    var id_branch = "<?php echo $branch;?>";
    console.log(id_branch);
    // Build the chart
    $("#area-chart").empty();
    if (id_branch !== "all") {
        reportso(id_branch,1);
        reportincome(id_branch,1);
    } else {
        reportso("all",1);
        reportincome("all",1);
    }
    
});

function reportso(branch,pos) {
    var d = new Date();
    var html = '<div class="col-lg-6">' +
                    '<div id="container-so-'+pos+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>' +
                ' </div>';
    $("#area-chart").append(html);

    var dt = {branch: branch, month: d.getMonth(), year: d.getYear()};

    $.ajax({
        type: "POST",
        url: '<?php echo base_url('r_penjualan/getReport');?>',
        data: dt,
        success: function(i, data){
            console.log(data);
        },
        dataType: 'json'
    })
    .done(function (data){
        Highcharts.chart('container-so-'+pos, {
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
                title: {
                    text: 'Value'
                }
            },
            navigation: {
                buttonOptions: {
                        enabled: true
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Sales Order',
                data: data.value
            }]
        });
    });
}

function reportincome(branch,pos) {
    var d = new Date();
    var html = '<div class="col-lg-6">' +
                    '<div id="container-income-'+pos+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>' +
                ' </div>';
    $("#area-chart").append(html);

    var dt = {branch: branch, month: d.getMonth(), year: d.getYear()};
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
        Highcharts.chart('container-income-'+pos, {
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
                name: 'Income (Rp)',
                data: data.value
            }]
        });
    });
}
</script>