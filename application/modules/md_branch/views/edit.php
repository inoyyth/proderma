<div class="row">
    <div class="col-md-6">
    <form action="<?php echo base_url("branch-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="block-web">
            <div class="porlets-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <input type="text" name="branch_code" value="<?php echo $data['branch_code'];?>" parsley-trigger="change" required placeholder="Branch Code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="branch_name" value="<?php echo $data['branch_name'];?>" parsley-trigger="change" required placeholder="Branch Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="branch_address" parsley-trigger="change" required placeholder="Branch Address" class="form-control"><?php echo $data['branch_address'];?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="branch_email" value="<?php echo $data['branch_email'];?>" parsley-trigger="change" data-parsley-type="email" required placeholder="Branch Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Telp</label>
                            <input type="text" name="branch_telp" value="<?php echo $data['branch_telp'];?>" parsley-trigger="change" data-parsley-type="number" required placeholder="Branch Telp" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="branch_status" placeholder="Status" required class="form-control">
                                <option value="1" <?php echo ($data['branch_status']=='1' ? 'selected' : '');?>>Aktif</option>
                                <option value="2"<?php echo ($data['branch_status']=='2' ? 'selected' : '');?>>Non Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="<?php echo site_url('branch'); ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </form>
    </div>
    <div class="col-lg-6">
        <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" style="min-height: 109px;">
            <div class="widget-box widget-color-blue2 ui-sortable-handle" style="opacity: 1;">
                <div class="widget-header widget-header-small">
                    <h6 class="widget-title smaller">Bank Of Branch</h6>
                    <div class="widget-toolbar">
                        <button type="button" id="btn-add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> New</button>
                        <button id="btn-edit" class="btn btn-xs btn-warning btn-dsb"><i class="fa fa-edit"></i> Edit</button>
                        <button type="button" id="btn-delete" class="btn btn-xs btn-danger btn-dsb"><i class="fa fa-remove"></i> Delete</button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div id="example-table"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal bank-->
<div class="modal fade" id="modal-bank" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-bank-title"></h4>
            </div>
            <form method="post" id="form-bank" action="<?php echo base_url('md_branch/saveBank');?>" enctype="multipart/form-data" parsley-validate novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="hidden" required="true" name="id_branch" value="<?php echo $data['id'];?>">
                                <input type="hidden" class="form-control" name="id" id="id_bank">
                                <input name="branch_bank_name" id="branch_bank_name" class="form-control input-sm" required="true" parsley-trigger="change" placeholder="Ex. BCA">
                            </div>
                            <div class="form-group">
                                <label>Account Name</label>
                                <input name="branch_bank_account_name" id="branch_bank_account_name" class="form-control input-sm" required="true" parsley-trigger="change" placeholder="Ex. Proderma">
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <input name="branch_bank_account_branch" id="branch_bank_account_branch" class="form-control input-sm" required="true" parsley-trigger="change" placeholder="Ex. KCP Kelapa Gading">
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input name="branch_bank_account_number" id="branch_bank_account_number" class="form-control input-sm" required="true" parsley-type="number" parsley-trigger="change" placeholder="Ex. 0987654321">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="branch_bank_status" id="branch_bank_status" class="form-control input-sm">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal bank-->
<script>
    $(document).ready(function(){
       $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
       $("#example-table").tabulator({
            fitColumns: true,
            pagination: true,
            movableCols: true,
            height: "320px", // set height of table (optional),
            pagination:"remote",
            paginationSize: 10,
            fitColumns:true, //fit columns to width of table (optional),
            ajaxType: "POST", //ajax HTTP request type
            ajaxURL: "<?php echo base_url('md_branch/getListBank/'.$data['id']); ?>", //ajax URL
            //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
            columns: [//Define Table Columns
                {formatter: "rownum", align: "center", width: 40},
                {title: "Name", field: "branch_bank_name", sorter: "string", tooltip: true},
                {title: "Branch", field: "branch_bank_account_branch", sorter: "string", tooltip: true},
                {title: "Acc.Name", field: "branch_bank_account_name", sorter: "string", tooltip: true},
                {title: "Acc.Number", field: "branch_bank_account_number", sorter: "string", tooltip: true},
                {title: "Status", field: "status", sorter: "string", tooltip: true},
            ],
            selectable: 1,
            rowSelectionChanged: function (data, rows) {
                if (data.length > 0) {
                    $(".btn-dsb").removeAttr('disabled',true).css('pointer-events','auto');
                } else {
                    $(".btn-dsb").attr('disabled',true).css('pointer-events','none');
                }
            }
        }); 
    
        $("#btn-add").click(function(){
            $("#modal-bank-title").text('Add Bank');
            $("#form-bank .form-control").val('');
            $("#modal-bank").modal('show');
        });
        $("#btn-edit").click(function(){
            $("#modal-bank-title").text('Update Bank');
            var selectedData = $("#example-table").tabulator("getSelectedData");
            $('#id_bank').val(selectedData[0]['id']);
            $('#branch_bank_name').val(selectedData[0]['branch_bank_name']);
            $('#branch_bank_account_name').val(selectedData[0]['branch_bank_account_name']);
            $('#branch_bank_account_branch').val(selectedData[0]['branch_bank_account_branch']);
            $('#branch_bank_account_number').val(selectedData[0]['branch_bank_account_number']);
            $('#branch_bank_status').val(selectedData[0]['branch_bank_status']);
            $("#modal-bank").modal('show');
        }); 
        
        $('#form-bank').submit(function(event) {
            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
             // validate form with parsley.
            $(this).parsley().validate();
            // if this form is valid
            if ($(this).parsley().isValid()) {
                 $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(), // serializes the form's elements.
                    dataType: "json",
                    success: function(data){
                        $("#example-table").tabulator("setData", "<?php echo base_url('md_branch/getListBank/'.$data['id']); ?>");
                        $("#modal-bank").modal('hide');
                    },
                    error: function(data){
                        console.log(data);
                    }
                  });
            } else {
                return false;
            }
        });
        
        $("#btn-delete").click(function(){
        var selectedData = $("#example-table").tabulator("getSelectedData");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('md_branch/deleteBank');?>",
                data: {id:selectedData[0]['id']}, // serializes the form's elements.
                success: function(data){
                    $("#example-table").tabulator("setData", "<?php echo base_url('md_branch/getListBank/'.$data['id']); ?>");
                    alert('Delete data is success !!!');
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });
</script>