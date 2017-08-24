<link rel="stylesheet" href="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/css/highcharts.css" />
<div class="row">
    <div class="space-6"></div>

    <div class="col-sm-7 infobox-container">
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
        
        <div class="infobox infobox-grey infobox-small infobox-dark">
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
    </div>

    <div class="vspace-12-sm"></div>

    <div class="col-sm-5">
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
    </div><!-- /.col -->
</div><!-- /.row -->

<div class="hr hr32 hr-dotted"></div>

<script src="<?php echo base_url(); ?>themes/assets/plugin/Highcharts-5.0.14/code/js/highcharts.js"></script>
<script>
$(document).ready(function () {
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            height: 300,
        },
        title: {
            text: 'Statistic Of Areas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: <?php echo $mapping_area; ?>
        }]
    });
});
</script>