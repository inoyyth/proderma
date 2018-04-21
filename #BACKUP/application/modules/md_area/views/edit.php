<div class="row">
    <form action="<?php echo base_url("master-area-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>Area Code</label>
                                <input type="text" name="area_code" value="<?php echo $data['area_code'];?>" parsley-trigger="change" required placeholder="Area Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Area Name</label>
                                <input type="text" name="area_name" value="<?php echo $data['area_name'];?>" parsley-trigger="change" required placeholder="Area Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Area Description</label>
                                <textarea name="area_description" parsley-trigger="change" required placeholder="Area Description" class="form-control"><?php echo $data['area_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="area_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['area_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['area_status']=="2"?"selected":"");?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('master-area'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>