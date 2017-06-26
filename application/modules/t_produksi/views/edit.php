<div class="row">
    <form action="<?php echo base_url("employee-level-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="jabatan" value="<?php echo $data['jabatan'];?>" parsley-trigger="change" required placeholder="Level" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="jabatan_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['jabatan_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['jabatan_status']=="2"?"selected":"");?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('employee-level'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>