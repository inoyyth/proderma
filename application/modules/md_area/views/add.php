<div class="row">
    <form action="<?php echo base_url("master-area-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Area Code</label>
                                <input type="text" name="area_code" parsley-trigger="change" required placeholder="Area Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Area Name</label>
                                <input type="text" name="area_name" parsley-trigger="change" required placeholder="Area Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Area Description</label>
                                <textarea name="area_description" parsley-trigger="change" required placeholder="Area Description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="area_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('master-area'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>