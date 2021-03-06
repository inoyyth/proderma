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
    <?php if ($branch == "all") { ?>
    <div class="vspace-12-sm"></div>
    <div class="col-lg-12">
        <div id="container-branch" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    <?php } ?>
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
    var dN = new Date();
    console.log(id_branch);
    var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    // Build the chart
    $("#area-chart").empty();
    if (id_branch !== "all") {
        $.ajax({
        type: "POST",
        url: '<?php echo base_url('dashboard/getAllBranchWhere');?>',
        data: {branch:id_branch},
        success: function(i, data){
            console.log(data);
        },
        dataType: 'json'
        }).done(function(e){
            //$.each(e,function(i, item){
                //reportso(item.id,item.branch_name,i);
                reportincome(e.id,e.branch_name,1); 
            //});
            console.log(e);
        });
    } else {
        $.ajax({
        type: "POST",
        url: '<?php echo base_url('dashboard/getAllBranch');?>',
        data: {branch:'all'},
        success: function(i, data){
            console.log(data);
        },
        dataType: 'json'
        }).done(function(e){
            $.each(e,function(i, item){
                //reportso(item.id,item.branch_name,i);
                reportincome(item.id,item.branch_name,i); 
            });
        });
    }

    $.ajax({
        type: "POST",
        url: '<?php echo base_url('dashboard/getReportAll');?>',
        data: {month: dN.getMonth()+1, year: dN.getFullYear()},
        success: function(i, data){
            console.log(data);
        },
        dataType: 'json'
    })
    .done(function (dataV){
        Highcharts.chart('container-branch', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Income Report All Branch in ' + monthNames[dN.getMonth()]
            },
            subtitle: {
                text: 'Income Chart'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Value (Rp)'
                }
            },
            lang: {
                decimalPoint: '.',
                thousandsSep: ','
            },
            legend: {
                enabled: true
            },
            tooltip: {
                pointFormat: 'Total income: <b>{point.y:,.0f}</b>'
            },
            series: [{
                name: 'Income',
                data: dataV,
                dataLabels: {
                    enabled: true,
                    //rotation: -90,
                    color: '#FFFFFF',
                    align: 'center',
                    format: '{point.y:.1f}', // one decimal
                    y: 5, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    },
                    format: '{point.y:,.0f}'
                }
            }]
        });
    });
    
});
Highcharts.setOptions({
    lang: {
        thousandsSep: '.'
    }
});

function reportso(branch,name,pos) {
    var d = new Date();
    var html = '<div class="col-lg-6">' +
                    '<div id="container-so-'+pos+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>' +
                ' </div>';
    $("#area-chart").append(html);

    var dt = {branch: branch, month: d.getMonth()+1, year: d.getFullYear()};

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
                text: name
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

function reportincome(branch,name,pos) {
    var d = new Date();
    var html = '<div class="col-lg-12">' +
                    '<div id="container-income-'+pos+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>' +
                ' </div>'+
                '<div class="col-lg-12" ><ul class="list-group"><li class="list-group-item list-group-item-success">' +
                '<h4>Target: <span id="target-'+pos+'">0</span> &nbsp; Achievement: <span id="achieve-'+pos+'">0</span> &nbsp; Percentage: <span id="percentage-'+pos+'">0%</span></h4>'
                '</li></ul></div><br/><br/>';
    $("#area-chart").append(html);

    var dt = {branch: branch, month: d.getMonth()+1, year: d.getFullYear()};
    $.ajax({
        type: "POST",
        url: '<?php echo base_url('dashboard/getReport');?>',
        data: dt,
        success: function(i, data){
            console.log(data);
        },
        dataType: 'json'
    })
    .done(function (data){
        $("#target-"+pos).text(data.target.target_branch);
        $("#achieve-"+pos).text(data.target.achievement);
        $("#percentage-"+pos).text(data.target.percentage+'%');
        Highcharts.chart('container-income-'+pos, {
            chart: {
                type: 'line'
            },
            title: {
                text: data.title
            },
            subtitle: {
                text: name
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