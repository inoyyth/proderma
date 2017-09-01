<div class="row">
    <form action="<?php echo base_url("branch-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="branch_code" parsley-trigger="change" required placeholder="Branch Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="branch_name" parsley-trigger="change" required placeholder="Branch Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="branch_address" parsley-trigger="change" required placeholder="Branch Address" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="branch_email" parsley-trigger="change" data-parsley-type="email" required placeholder="Branch Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Telp</label>
                                <input type="text" name="branch_telp" parsley-trigger="change" data-parsley-type="number" required placeholder="Branch Telp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="branch_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('branch'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>