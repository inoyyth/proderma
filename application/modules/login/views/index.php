<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 2 | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>themes/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>themes/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>themes/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="row">
            <div class="col-lg-12" style="background-color: #08377B;height: 120px;">
                <img src="<?php echo base_url(); ?>themes/dist/img/bank-lampung-logo.png" class="pull-left" style="height: 120px;">
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-8">
                <img src="<?php echo base_url(); ?>themes/dist/img/nyepi-webbanner-corsec.jpg" style="width: 899px;height: 224px;">
            </div>
            <div class="col-lg-4">
                <div class="login-box" style="margin-top: -0px;">
                    <!-- /.login-logo -->
                    <div class="login-box-body" style="font-size: 16px;">
                        <p class="login-box-msg"><b>Management Information System</b></p>

                        <form action="<?php echo base_url(); ?>home" method="post">
                            <div class="form-group has-feedback">
                                <input type="email" class="form-control" placeholder="Email">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                    </div>
                    <!-- /.login-box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <div class="row" style="padding: 43px; margin-top: -60px;">
                    <div class="panel panel-default">
                    <div class="panel-heading">Kurs Bank Lampung *</div>
                    <div class="panel-body">
                        <div style="letter-spacing: 3px;text-align: center;"><?php echo date('d'); ?> <?php echo date('M'); ?> <?php echo date('y'); ?> <?php echo date('H:i'); ?> WIB</div>
                        <div>
                            <table class="table table-striped">
                                <tr>
                                    <th style="text-align: center;">Kurs</th>
                                    <th style="text-align: center;">Beli</th>
                                    <th style="text-align: center;">Jual</th>
                                </tr>
                                <tr>
                                    <td>USD</td>
                                    <td style="text-align: right;">13.310,00</td>
                                    <td style="text-align: right;">13.330,00</td>
                                </tr>
                                <tr>
                                    <td>EUR</td>
                                    <td style="text-align: right;">14.210,00</td>
                                    <td style="text-align: right;">14.245,00</td>
                                </tr>
                                <tr>
                                    <td>SGD</td>
                                    <td style="text-align: right;">9.520,00</td>
                                    <td style="text-align: right;">9.560,00</td>
                                </tr>
                                <tr>
                                    <td>JPY</td>
                                    <td style="text-align: right;">119,45</td>
                                    <td style="text-align: right;">119,80</td>
                                </tr>
                                <tr>
                                    <td>AUD</td>
                                    <td style="text-align: right;">10.125,00</td>
                                    <td style="text-align: right;">10.160,00</td>
                                </tr>
                            </table>
                            <div>
                                <label style="text-align: justify;">
                                    *merupakan kurs indikasi untuk transaksi dengan 
                                    nominal di atas USD 25.000 (ekivalen), jika nasabah 
                                    akan bertransaksi dapat segera menghubungi cabang 
                                    untuk mendapatkan kurs yang berlaku
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url(); ?>themes/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>themes/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>themes/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
