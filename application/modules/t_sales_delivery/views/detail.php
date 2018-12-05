<div class="row">
    <form action="<?php echo base_url("sales-delivery-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery Order Code</label>
                                <input type="text" name="do_code" readonly="true" value="<?php echo $data['do_code']; ?>" parsley-trigger="change" required  class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sales Order Code</label>
                                <input type="text" class="form-control" readonly="true" name="id_so" id="id_so" value="<?php echo $data['so_code']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Delivery Order Date</label>
                                <input type="text" name="do_date" readonly="true" value="<?php echo $data['do_date']; ?>" parsley-trigger="change" required  class="form-control date-picker">
                            </div>
                            <!--<div class="form-group">
                                <label>Bonus</label>
                                <textarea name="do_bonus" readonly="true" class="form-control"><?php echo $data['do_bonus']; ?></textarea>
                            </div>-->
                        </div>
                    </div>
                    <a href="<?php echo site_url('sales-delivery'); ?>" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12">
        <div id="product-table"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#product-table").tabulator({
            fitColumns: true,
            pagination: false,
            movableCols: false,
            height: "200px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 20,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_sales_order/getProductList/'.$data['id_so']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Code", field: "product_code", sorter: "string", tooltip: true},
                {title: "Name", field: "product_name", sorter: "string", tooltip: true},
                {title: "Qty", field: "qty", sorter: "number", tooltip: true},
                {title: "Price", field: "product_price", formatter: "money", sorter: "number", tooltip: true},
                {title: "SubTotal", field: "SubTotal", formatter: "money", sorter: "number", tooltip: true},
                {title: "Desc", field: "description", sorter: "string", tooltip: true},
                {title: "Bonus", field: "bonus_item", sorter: "number", tooltip: true},
            ]
        });
    });
</script>