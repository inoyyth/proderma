<div class="row">
    <form id="formId" action="<?php echo base_url("invoice-save"); ?>" method="post" enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No. Faktur</label>
                                <input type="text" name="no_faktur" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Delivery Order Code</label>
                                <input type="hidden" name="id_do" id="id_do">
                                <input type="hidden" name="id_so" id="id_so">
                                <div class="input-group">
                                    <input type="text" name="do_code" id="do_code" readonly="true" parsley-trigger="change" required class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary btn-sm" id="browse-so" onclick="showModal();" type="button">Browse!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Invoice Date</label>
                                <input type="text" name="invoice_date" value="<?php echo date('Y-m-d');?>"  parsley-trigger="change" required  class="form-control date-picker">
                            </div>
                            <div id="payment-content" style="display: none;">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="hidden" name="date_status" id="date-status" value="2">
                                    <input type="text" name="due_date" id="due-date" class="form-control" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('invoice'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="doModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Sales Order List</h4>
            </div>
            <div class="modal-body" style="height: 400px;">
                <div class="row">
                    <form class="form-filter-table">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="small">SO.Code</label>
                                <input type="text" class="form-control input-sm" id="search-so-code">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="small">Customer Name</label>
                                <input type="text" class="form-control input-sm" id="search-customer-name">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="small">DO.Code</label>
                                <input type="text" class="form-control input-sm" id="search-do-code">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-xs btn-success" onclick="filterTable();">Filter</button>
                                <button type="button" class="btn btn-xs btn-warning" onclick="clearFilterTable();">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="select-do">Select</button>
            </div>
        </div>
    </div> 
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12" id="so-detail"></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#select-do").click(function(){
            $("#product-table").remove();
            $("#so-detail").append('<div id="product-table"></div>');
            var selectedData = $("#do-table").tabulator("getSelectedData");
            console.log(selectedData);
            $("#product-table").tabulator({
                fitColumns: true,
                pagination: false,
                movableCols: false,
                height: "200px", // set height of table (optional),
                pagination:"remote",
                paginationSize: 20,
                fitColumns:true, //fit columns to width of table (optional),
                ajaxType: "POST", //ajax HTTP request type
                ajaxURL: "<?php echo base_url('t_sales_order/getProductList/');?>" + selectedData[0]['id_so'], //ajax URL
                columns: [//Define Table Columns
                    {formatter: "rownum", align: "center", width: 40},
                   //{title: "Area", field: "area_name", sorter: "string", tooltip: true},
                    {title: "Code", field: "product_code", sorter: "string", tooltip: true},
                    {title: "Name", field: "product_name", sorter: "string", tooltip: true},
                    {title: "Qty", field: "qty", sorter: "number", tooltip: true},
                    {title: "Price", field: "product_price", formatter: "money", sorter: "number", tooltip: true},
                    {title: "SubTotal", field: "SubTotal", formatter: "money", sorter: "number", tooltip: true},
                    {title: "Desc", field: "description", sorter: "string", tooltip: true},
                ],
                dataLoaded: function (data) {
                    $("#doModal").modal('hide');
                    $("#id_so").val(selectedData[0]['id_so']);
                    $("#id_do").val(selectedData[0]['id']);
                    $("#do_code").val(selectedData[0]['do_code']);
					
                    if (selectedData[0]['so_payment_term'] == 3) {
						//console.log(selectedData[0]['do_date']);
						var someDate = new Date(selectedData[0]['do_date']);
						someDate.setDate(someDate.getDate() + 21); //number  of days to add, e.x. 15 days
						var dateFormated = someDate.toISOString().substr(0,10);
						
						$("#due-date").val(dateFormated);
                        $("#payment-content").show();
                        $("#date-status").val('1');
                    } else {
                        $("#date-status").val('2');
                        $("#payment-content").hide();
                    }
                }
            });
        });
        
        $("#formId").submit(function() {
            if ($("#date-status").val() == 1) {
                if ($("#due-date").val() === '') {
                    alert('Please select due date');
                    return false;
                }
            }
        });
    });

    function showModal() {
        $("#doModal").modal('show');
        $("#do-table").remove();
        $(".modal-body").append('<div id="do-table"></div>');
        $("#do-table").tabulator({
            fitColumns: true,
            responsiveLayout: true,
            pagination: true,
            movableCols: true,
            height: "300px", // set height of table (optional),
            pagination:"remote",
                    paginationSize: 10,
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('t_invoice/getListTableDo'); ?>", //ajax URL
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 20},
                {title: "SO.Code", field: "so_code", sorter: "string", tooltip: true},
                {title: "DO.Code", field: "do_code", sorter: "string", tooltip: true},
                {title: "Cust.Name", field: "customer_name", sorter: "string"},
                {title: "SO.Date", field: "so_date", sorter: "string"},
                {title: "DO.Date", field: "do_date", sorter: "string"}
            ],
            selectable: 1,
            dataLoaded: function (data) {

            }
        });
    }

    function clearFilterTable() {
        $(".form-filter-table")[0].reset();
        filterTable();
    }

    function filterTable() {
        console.log('filter');
        var params = {
            so_code: $('#search-so-code').val(),
            customer_name: $('#search-customer-name').val(),
            do_code: $('#search-do-code').val(),
        };

        $("#do-table").tabulator("setData", "<?php echo base_url('t_invoice/getListTableDo'); ?>", params);
    }
</script>