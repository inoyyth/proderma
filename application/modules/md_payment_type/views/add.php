<div class="row">
    <form action="<?php echo base_url("master-payment-type-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <input type="text" name="payment_type" parsley-trigger="change" required placeholder="Payment Type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="payment_type_description" parsley-trigger="change" required placeholder="Description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="payment_type_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('master-payment-type'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>