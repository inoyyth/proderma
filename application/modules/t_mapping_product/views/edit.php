<div id="user-profile-1" class="user-profile row">
    <div class="col-xs-12 col-sm-3 center">
        <div>
            <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" style="height: 143px;" alt="<?php echo $customer['customer_name']; ?>" src="<?php echo base_url($customer['photo_path']); ?>" />
            </span>

            <div class="space-4"></div>

            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">

                    <i class="ace-icon fa fa-circle light-green"></i>
                    &nbsp;
                    <span class="white"><?php echo $customer['customer_code']; ?></span>

                </div>
            </div>
        </div>

        <div class="space-6"></div>

    </div>
    <form method="post" action="<?php echo base_url('mapping-product-save'); ?>">
        <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
        <div class="col-xs-12 col-sm-9">

            <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name"> Name </div>

                    <div class="profile-info-value">
                        <span class="editable" id="username"><?php echo $customer['customer_name']; ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Clinic </div>

                    <div class="profile-info-value">
                        <span class="editable" id="city"><?php echo $customer['customer_clinic']; ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Email </div>

                    <div class="profile-info-value">
                        <span class="editable" id="login"><?php echo $customer['customer_email']; ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Group </div>

                    <div class="profile-info-value">
                        <div class="form-group">
                            <select name="id_group_customer_product" id="id-group-product" parsley-trigger="change" required placeholder="Group" class="form-control">
                                <option value=""></option>
                                <?php foreach ($group as $vGroup) { ?>
                                    <option value="<?php echo $vGroup['id']; ?>" <?php echo ($customer['id_group_customer_product'] == $vGroup['id'] ? "selected" : ""); ?>><?php echo $vGroup['group_customer_product']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Area </div>

                    <div class="profile-info-value">
                        <span class="editable" id="signup"><?php echo $customer['area_code'] . " / " . $customer['area_name']; ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Sub Area </div>

                    <div class="profile-info-value">
                        <span class="editable" id="login"><?php echo $customer['subarea_code'] . " / " . $customer['subarea_name']; ?></span>
                    </div>
                </div>

            </div>
            <br>
            <div class="container">
                <input type="submit" class="btn btn-primary btn-sm" value="Save"> 
                <a href="<?php echo base_url('mapping-product'); ?>" class="btn btn-warning btn-sm">Cancel</a>
            </div>

            <div class="space-20"></div>

        </div>
    </form>

    <div class="col-xs-12 col-sm-12">
        <div class="col-lg-5">
            <div id="available-product"></div>
        </div>
        <div class="col-lg-2">
            <div style="margin-top: 100%;">
                <center>
                    <button class="btn btn-default" id="product-add"> >> </button> <br>
                    <button class="btn btn-default" id="product-remove"> << </button>
                </center>
            </div>
        </div>
        <div class="col-lg-5">
            <div id="current-product"></div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        var idCustomer = <?php echo $customer['id']; ?>;
        $("#available-product").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 50,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            groupBy: "product_category",
            ajaxURL: "<?php echo base_url('t_mapping_product/getAvailableProduct/' . $customer['id']); ?>", //ajax URL
            ajaxParams: {group_product: $("#id-group-product").val()},
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Sub Category", field: "sub_category_name", sorter: "string", tooltip: true},
                {title: "Name", field: "product_name", sorter: "string", tooltip: true},
            ],
            selectable: 100
        });

        $("#current-product").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: false,
            height: "520px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 50,
            fitColumns:true, //fit columns to width of table (optional),
                    ajaxType: "POST", //ajax HTTP request type
            groupBy: "product_category",
            ajaxURL: "<?php echo base_url('t_mapping_product/getCurrentProduct/' . $customer['id']); ?>", //ajax URL
            //ajaxParams: {group_product:$("#id-group-product").val()},
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                {title: "Sub Category", field: "sub_category_name", sorter: "string", tooltip: true},
                {title: "Name", field: "product_name", sorter: "string", tooltip: true},
            ],
            selectable: 100
        });

        $("#product-add").click(function (e) {
            e.preventDefault();
            var availableProduct = $("#available-product").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_product/insertProduct'); ?>",
                type: "POST",
                dataType: "json",
                cache: false,
                data: {id_customer: idCustomer, arrayData: availableProduct}
            }).done(function () {
                console.log("success");
                $("#current-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getCurrentProduct/' . $customer['id']); ?>");
                $("#available-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getAvailableProduct/' . $customer['id']); ?>", {group_product: $("#id-group-product").val()});
            }).fail(function () {
                console.log("error");
            }).always(function () {
                console.log("complete");
            });
        });

        $("#product-remove").click(function (e) {
            e.preventDefault();
            var currentProduct = $("#current-product").tabulator("getSelectedData");
            $.ajax({
                url: "<?php echo base_url('t_mapping_product/removeProduct'); ?>",
                type: "POST",
                dataType: "json",
                cache: false,
                data: {id_customer: idCustomer, arrayData: currentProduct}
            }).done(function () {
                console.log("success");
                $("#current-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getCurrentProduct/' . $customer['id']); ?>");
                $("#available-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getAvailableProduct/' . $customer['id']); ?>", {group_product: $("#id-group-product").val()});
            }).fail(function () {
                console.log("error");
            }).always(function () {
                console.log("complete");
            });
        });

        var indexGroupProduct = $("#id-group-product").prop('selectedIndex');
        $("#id-group-product").change(function (e) {
            e.preventDefault();

            var conf = confirm('Yakin akan mengganti group product? Jika ya maka product akan di reset.');
            if (!conf) {
                $(this).prop('selectedIndex', indexGroupProduct);
                return false;
            } else {
                $.ajax({
                    url: "<?php echo base_url('t_mapping_product/resetProduct'); ?>",
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    data: {id_customer: idCustomer}
                }).done(function () {
                    console.log("success");
                    $("#current-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getCurrentProduct/' . $customer['id']); ?>");
                    $("#available-product").tabulator("setData", "<?php echo base_url('t_mapping_product/getAvailableProduct/' . $customer['id']); ?>", {group_product: $("#id-group-product").val()});
                }).fail(function () {
                    console.log("error");
                }).always(function () {
                    console.log("complete");
                });
            }
        });
    });
</script>