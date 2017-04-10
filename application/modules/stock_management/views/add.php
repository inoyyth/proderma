<div class="row">
    <form action="<?php echo base_url("product-category-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product Category Add</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('product-category'); ?>" class="btn btn-default pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="remote">
                                <label>Category Code</label>
                                <input style="text-transform: uppercase;" type="text" value="<?php echo $code;?>" name="product_category_code" parsley-trigger="change" required placeholder="Fill Category Code" class="form-control typeahead">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="product_category_name" parsley-trigger="change" required placeholder="Fill Category Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_category_description"placeholder="Fill Category Description" class="form-control mytextarea"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="product_category_status" placeholder="Pilih Status" required class="form-control">
                                    <option value=""></option>
                                    <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                    <option value="<?php echo $vStatus['code'];?>"><?php echo $vStatus['value'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {

        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo base_url('t_pdi/get_sales_order?query=%QUERY'); ?>',
                wildcard: '%QUERY'
            }
        });

        $('#remote .typeahead').typeahead(null, {
            name: 'noso',
            display: 'noso',
            source: bestPictures
        });

        $('#remote .typeahead').bind('typeahead:selected', function (obj, datum, name) {
            console.log(datum);
            $('#noso').val(datum.noso);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('t_pdi/get_detail_so'); ?>",
                dataType: "json",
                data: {id: datum.id},
                success: function (result) {
                    //console.log(result.master_motor[0].nama_motor);
                    $('#harga_otr').val(result.master_motor.harga_otr);
                    $('#nama').val(result.customer[0].nama_customer);
                    $('#tanggal').val(result.penjualan[0].tanggal);
                    $('#type').val(result.terima_motor[0].tipe);
                    $('#no_mesin').val(result.terima_motor[0].nomesin);
                    $('#no_rangka').val(result.terima_motor[0].norangka);
                    $('#warna').val(result.terima_motor[0].warna);
                },
                async: false
            });

            //$('#terbilang').val(datum.terbilang);
            //$('#norangka').val(datum['norangka']);
            //$('#warna').val(datum['warna']);
            //$('#tahun').val(datum['tahun']);
        });
    });
</script>