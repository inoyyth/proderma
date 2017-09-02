<div class="row">
    <form action="<?php echo base_url("visit-form-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="visit_form_code" parsley-trigger="change" required placeholder="code" value="<?php echo $code;?>" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="visit_form_subject" parsley-trigger="change" required placeholder="Subject" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sales</label>
                                <select name="visit_form_sales" parsley-trigger="change" required placeholder="Sales" class="form-control">
                                    <option value="" selected="true"> - </option>
                                    <?php
                                        foreach($employee as $kEmployee=>$vEmployee) {
                                            echo "<option value='".$vEmployee['id']."'>".$vEmployee['employee_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Activity</label>
                                <select name="visit_form_activity" parsley-trigger="change" required placeholder="Activity" class="form-control">
                                    <option value="" selected="true"> - </option>
                                    <?php
                                        foreach($activity as $kActivity=>$vActivity) {
                                            echo "<option value='".$vActivity['id']."'>".$vActivity['activity_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="remote-attendance">
                                <label class="small">Customer</label>
                                <input type="hidden" id="visit-form-attendence" name="visit_form_attendence">
                                <input class="typeahead form-control input-sm" style="text-transform: uppercase;" required="true" type="text">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="visit_form_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control" placeholder="Start Date" name="visit_form_start_date" />
                                    <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                    </span>
                                    <input type="text" class="input-sm form-control" placeholder="End Date" name="visit_form_end_date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" name="visit_form_location" parsley-trigger="change" required placeholder="Location" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="visit_form_description" parsley-trigger="change" required placeholder="Description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('visit-form'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        //autocomplete
        var searchDataAttendence = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
              url: '<?php echo base_url('t_visit_form/getCustomerList?query=%QUERY');?>',
              wildcard: '%QUERY'
            }
        });

        $('#remote-attendance .typeahead').typeahead(null, {
          name: 'cus_concat',
          display: 'cus_concat',
          source: searchDataAttendence,
          minLength: 3,
          highlight: true,
          limit: 10
        });
        
        $('#remote-attendance .typeahead').bind('typeahead:selected', function(obj, datum, name) {
            $("#visit-form-attendence").val(datum.id);
        });
    });
</script>