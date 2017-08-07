<div class="row">
    <form action="<?php echo base_url("payment-due-date-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>SO.Code</label>
                                <input type="text" readonly="true" value="<?php echo $data['so_code'];?>" parsley-trigger="change" required placeholder="Level" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>DO.Code</label>
                                <input type="text" readonly="true" value="<?php echo $data['do_code'];?>" parsley-trigger="change" required placeholder="Level" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Invoice Code</label>
                                <input type="text" readonly="true" value="<?php echo $data['invoice_code'];?>" parsley-trigger="change" required placeholder="Level" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="pay_duedate_status" placeholder="Status" required class="form-control">
                                    <option value="WAIT" <?php echo ($data['pay_duedate_status']=="WAIT"?"selected":"");?>>WAIT</option>
                                    <option value="DONE" <?php echo ($data['pay_duedate_status']=="DONE"?"selected":"");?>>DONE</option>
                                    <option value="BROKE" <?php echo ($data['pay_duedate_status']=="BROKE"?"selected":"");?>>BROKE</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input type="text" name="pay_date" value="<?php echo $data['pay_date'];?>" parsley-trigger="change" required placeholder="Pay Date" class="form-control date-picker">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="pay_duedate_description" parsley-trigger="change" required placeholder="Description" class="form-control"><?php echo $data['pay_duedate_description'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('payment-due-date'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>