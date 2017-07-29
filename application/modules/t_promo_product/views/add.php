<div class="row">
    <form action="<?php echo base_url("promo-product-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Promo Code</label>
                                <input type="text" name="promo_code" readonly="true" parsley-trigger="change" required placeholder="Promo Code" value="<?php echo $code;?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Promo Name</label>
                                <input type="text" name="promo_name" parsley-trigger="change" required placeholder="Promo Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Promo Description</label>
                                <textarea name="promo_description" parsley-trigger="change" required placeholder="Promo Description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Promo File (.pdf)</label>
                                <input type="file" name="promo_file" parsley-trigger="change" required placeholder="Promo File" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control" placeholder="Start Date" name="promo_start_date" />
                                    <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                    </span>
                                    <input type="text" class="input-sm form-control" placeholder="End Date" name="promo_end_date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="promo_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('promo-product'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>