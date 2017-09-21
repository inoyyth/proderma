<?php
if ($data['so_discount_type'] == 'Fixed') {
    $discount_value = $data['so_discount_value'];
} else {
    $discount_value = (($data_product['grand_total'] * intval($data['so_discount_value'])) / 100);
}

$tax = (($data_product['grand_total'] * 10) / 100);

?>
<div class="row">
    <div class="col-lg-2">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo base_url($data['photo_path']); ?>" />
            </span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> NIP </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data['employee_nip']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['employee_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['employee_email']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup"><?php echo $data['employee_phone']; ?></span>
                </div>
            </div>
        </div>
        <br>
        <div class="row" style="padding-left: 24px;">
            <a href="<?php echo site_url('sales-order'); ?>" class="btn btn-warning btn-sm">Back</a>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> SO.Code </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data['so_code']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Cust.Code </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['customer_code']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Cust.Name </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['customer_name']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Date </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $data['so_date']; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-7">
        <div id="product-table"></div>
    </div>
    <div class="col-lg-5">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Item Type </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $data_product['total_type']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Total Item </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data_product['total_item']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Disc.Type </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['so_discount_type'] . ($data['so_discount_type'] == "Percent" ? " (" . $data['so_discount_value'] . "%)" : ""); ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Payment.Term </div>
                <div class="profile-info-value">
                    <span class="editable editable-click" id="city"><?php echo $data['payment_type']; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Total Price </div>
                <div class="profile-info-value text-right">
                    <span class="editable editable-click" id="city"><?php echo formatrp($data_product['grand_total']); ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Disc.Value (-) </div>
                <div class="profile-info-value text-right">
                    <span class="editable editable-click" id="city"><?php echo formatrp($discount_value); ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Tax(10%) (+) </div>
                <div class="profile-info-value text-right">
                    <span class="editable editable-click" id="city"><?php echo formatrp($tax); ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> TOTAL </div>
                <div class="profile-info-value text-right">
                    <span class="editable editable-click" id="city"><?php echo formatrp(((intval($data_product['grand_total']) - intval($discount_value)) + intval($tax))); ?></span>
                </div>
            </div>
			<div class="profile-info-row">
                <div class="profile-info-name"> Signature </div>
                <div class="profile-info-value text-right">
					<img class="img-responsive" src="<?php echo base_url($data['so_signature']);?>">
				</div>
			</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#product-table").tabulator({
            fitColumns: true,
            pagination: false,
            movableCols: false,
            height: "420px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 20,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_sales_order/getProductList/'.$data['id']); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
               //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Code", field: "product_code", sorter: "string", tooltip: true},
                {title: "Name", field: "product_name", sorter: "string", tooltip: true},
                {title: "Qty", field: "qty", sorter: "number", tooltip: true},
                {title: "Price", field: "product_price", formatter: "money", sorter: "number", tooltip: true},
                {title: "SubTotal", field: "SubTotal", formatter: "money", sorter: "number", tooltip: true},
                {title: "Desc", field: "description", sorter: "string", tooltip: true},
             ]
        });
    });
</script>
