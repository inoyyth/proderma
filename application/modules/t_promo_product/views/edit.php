<div class="row">
    <div class="col-md-6">
		<form action="<?php echo base_url("promo-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Promo Code</label>
                                <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                <input type="text" name="promo_code" readonly="true" parsley-trigger="change" required placeholder="Promo Code" value="<?php echo $data['promo_code'];?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Promo Name</label>
                                <input type="text" name="promo_name" parsley-trigger="change" value="<?php echo $data['promo_name'];?>" required placeholder="Promo Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Promo Description</label>
                                <textarea name="promo_description" parsley-trigger="change" required placeholder="Promo Description" class="form-control"><?php echo $data['promo_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Promo File (.pdf)</label>
                                <input type="file" name="promo_file" parsley-trigger="change" required placeholder="Promo File" class="form-control">
                                <input type="hidden" name="file_hidden" value="<?php echo $data['promo_file'];?>">
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control" placeholder="Start Date" value="<?php echo $data['promo_start_date'];?>" name="promo_start_date" />
                                    <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                    </span>
                                    <input type="text" class="input-sm form-control" placeholder="End Date" value="<?php echo $data['promo_end_date'];?>" name="promo_end_date" />
                                </div>
                            </div>
							<div class="form-group">
                                <label>Branch Selection</label>
								<input type="text" class="form-control" readonly id="branch-list" name="branch_list" value="<?php echo $data['id_branch'];?>" parsley-trigger="change" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="promo_status" placeholder="Status" required class="form-control" parsley-trigger="change" required>
                                    <option value="1" <?php echo ($data['promo_status'] == 1 ? 'selected' : '');?>>Aktif</option>
                                    <option value="2" <?php echo ($data['promo_status'] == 2 ? 'selected' : '');?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('promo-product'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
		</form>
	</div>
	<div class="col-md-6">
		<?php if ($admin_status == "2") { ?>
		<div id="example-table"></div>
		<?php } ?>
	</div>
</div>
<script>
   $(document).ready(function () {
	   var admin_status = <?php echo $admin_status;?>;
	   if (admin_status !== 2 ) {
		   $("#branch-list").val(<?php echo $this->sessionGlobal['id_branch'];?>);
	   } else {
			$("#example-table").tabulator({
				fitColumns: true,
				pagination: false,
				movableCols: true,
				height: "auto", // set height of table (optional),
				//pagination:"remote",
				//paginationSize: 10,
				fitColumns:true, //fit columns to width of table (optional),
				ajaxType: "POST", //ajax HTTP request type
				ajaxURL: "<?php echo base_url('t_promo_product/getListBranch'); ?>", //ajax URL
				//ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
				columns: [//Define Table Columns
					{formatter: "rownum", align: "center", width: 40},
					{title: "Branch Code", field: "branch_code", sorter: "string", tooltip: true, width: 170},
					{title: "Branch Name", field: "branch_name", sorter: "string", tooltip: true}
				],
				selectable: 300,
				rowSelectionChanged: function (data, rows) {
					var result = data.map(function(a) {return a.id;});
					$("#branch-list").val(result.join(","));
				},
				tableBuilt:function(){
					var string = $("#branch-list").val();
					var array = string.split(',');
					console.log(array);
					$.each(array, function (key, value){
						$("#example-table").tabulator("selectRow", value);
					});
					//$("#example-table").tabulator("selectRow", 1);
					//$("#example-table").tabulator("selectRow", 5);
				}
			});
		}	
	});
</script>