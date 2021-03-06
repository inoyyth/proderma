<div class="row">
    <form action="<?php echo base_url("ojt-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Visit Date</label>
                                <input type="hidden" name="id" value="<?php echo $detail['id'];?>">
                                <input type="text" name="sales_visit_date" value="<?php echo $detail['sales_visit_date'];?>" class="form-control date-picker">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" name="end_date" value="<?php echo $detail['end_date'];?>"  class="form-control date-picker">
                            </div>
                            <div class="form-group">
                                <label>Customer Type</label>
                                <select name="sales_visit_customer_type" id="customer-type" class="form-control">
                                    <option value="C" <?php echo $detail['sales_visit_customer_type'] == "C" ? "selected" : "" ;?>>Customer</option>
                                    <option value="L" <?php echo $detail['sales_visit_customer_type'] == "L" ? "selected" : "" ;?>>Lead Customer</option>
                                </select>
                            </div>
                            <div class="form-group" id="remote-attendance">
                                <label>Customer</label>
                                <input type="hidden" required="true" id="id-customer" value="<?php echo $detail['id_customer'];?>" name="id_customer">
                                <input id="atc" class="typeahead form-control input-sm" style="text-transform: uppercase;" placeholder="type customer code or name" required="true" value="<?php echo $customer_code['customer_code'] . " - " . $customer_code['customer_name'];?>" type="text">
                            </div>
                            <div class="form-group">
                                <label>Activity</label>
                                <select name="activity" id="activity" class="form-control" required="true">

                                </select>
                            </div>
							<div class="form-group">
                                <label>Related Code</label>
                                <input type="text" name="related_code" value="<?php echo $detail['related_code'];?>" class="form-control">
                            </div>
							<?php if($this->sessionGlobal['super_admin'] == "2"){ ?>
							<div class="form-group">
								<label>Branch Office</label>
								<select name="id_branch" parsley-trigger="change" required placeholder="Branch Office" class="form-control">
									<option value=""></option>
									<?php foreach($branch as $kBranch=>$vBranch) { ?>
									<option value="<?php echo $vBranch['id'];?>" <?php echo $detail['id_branch'] == $vBranch['id'] ? 'selected' : '' ;?>><?php echo $vBranch['branch_name'];?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sales</label>
                                <select name="id_sales" class="form-control" required="true">
                                    <option value="" selected="true" disabled="true"> - </option>
                                    <?php foreach($sales as $kSales=>$vSales) {?>
                                    <option value="<?php echo $vSales['id'];?>" <?php echo $detail['id_sales'] == $vSales['id'] ? 'selected' : '' ;?>><?php echo $vSales['employee_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Assistant Name</label>
                                <input type="text" name="assistant_name" value="<?php echo $detail['assistant_name'];?>" class="form-control" required="true">
                            </div>
                            <div class="form-group">
                                <label>Sales Visit Note</label>
                                <textarea type="text" name="sales_visit_note" class="form-control"><?php echo $detail['sales_visit_note'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" name="longitude" value="<?php echo $detail['longitude'];?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" name="latitude" value="<?php echo $detail['latitude'];?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('ojt'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        setActivity($("#customer-type").val(),<?php echo $detail['activity'];?>);
        $("#customer-type").change(function() {
            $("#id-customer").val('');
            $("#atc").val('');
            setActivity($(this).val(),0);
        });
        //autocomplete
        var searchDataAttendence = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
              url: '<?php echo base_url();?>t_sales_visit/getCustomerList',
              replace: function(url, uriEncodedQuery) {
                val = $('#customer-type').val();
                query = $('#atc').val();
                if (!val) return url;
                //correction here
                return url + '?query=' + encodeURIComponent(query) +'&cust_type=' + encodeURIComponent(val)
              }
            }
        });

        $('#remote-attendance .typeahead').typeahead(null, {
          name: 'cus_concat',
          display: 'cus_concat',
          source: searchDataAttendence,
          minLength: 3,
          highlight: true,
          hint: true,
          limit: 10
        });
        
        $('#remote-attendance .typeahead').bind('typeahead:selected', function(obj, datum, name) {
            $("#id-customer").val(datum.id);
        });
    });
    
    function setActivity(type,idActivity) {
        $.ajax({
            url: "<?php echo base_url('t_sales_visit/getActivity');?>",
            type: "POST",
            dataType: "json",
            cache:false,
            data: { consumer_type : type }
        }).done(function(e) {
            var opt = "";
            $.each(e, function(i, item){
                if (item.id == idActivity) {
                    opt += "<option value='"+item.id+"' selected>"+item.objective+"</option>";
                } else {
                    opt += "<option value='"+item.id+"'>"+item.objective+"</option>";
                }
            });
            $("#activity").html(opt);
        }).fail(function() {
            console.log( "error" );
        }).always(function() {
            console.log( "complete" );
        });
    }
</script>