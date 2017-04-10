<div class="row">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Field Pencarian</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tgl.Mulai</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right datepicker" type="text">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tgl.Akhir</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right datepicker" type="text">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Kantor Operasional</label>
                            <select class="form-control">
                                <option>- pilih -</option>
                                <option>Pusat</option>
                                <option>Cabang A</option>
                                <option>Cabang B</option>
                                <option>Cabang C</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Pertumbuhan 10 Tahun</label>
                            <input class="form-control" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tahun Berjalan</label>
                            <input class="form-control" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Perbandingan Realisasi</label>
                            <select class="form-control">
                                <option>- pilih -</option>
                                <option>Bulanan</option>
                                <option>Triwulan</option>
                                <option>Semester</option>
                                <option>Tahunan</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Pencairan</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-center">
                            <strong>Saldo: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="pelunasanSaldoChart" style="height: 140px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <div class="col-md-6">
                        <p class="text-center">
                            <strong>Nasabah: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="pelunasanNasabahChart" style="height: 140px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Pelunasan</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-center">
                            <strong>Saldo: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="pencairanChart" style="height: 140px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <div class="col-md-6">
                        <p class="text-center">
                            <strong>Nasabah: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="nasabahChart" style="height: 140px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Report Table</h3><small>Periode 1 Jan, 2014 - 30 Jul, 2014</small>

                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Type Kredit</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td>Pencairan Saldo</td>
                        <td>500.000.000</td>
                    </tr>
                    <tr>
                        <td>Pencairan Nasabah</td>
                        <td>390</td>
                    </tr>
                    <tr>
                        <td>Pelunasan Saldo</td>
                        <td>490.000.000</td>
                    </tr>
                    <tr>
                        <td>Pelunasan Nasabah</td>
                        <td>370</td>
                    </tr>
                    <tr>
                        <td>Penerimaan Pokok</td>
                        <td>370.000.000</td>
                    </tr>
                    <tr>
                        <td>Penerimaan Bunga</td>
                        <td>800.000.000</td>
                    </tr>
                    <tr>
                        <td>Saldo Debet</td>
                        <td>370</td>
                    </tr>
                    <tr>
                        <td>Expansi Kredit</td>
                        <td>370</td>
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>themes/dist/js/pages/pertumbuhan-kredit.js"></script>