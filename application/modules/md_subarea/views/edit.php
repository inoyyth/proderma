<div class="row">
    <form action="<?php echo base_url("master-subarea-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>Area Code / Name</label>
                                <select name="id_area" parsley-trigger="change" required placeholder="Area Code" class="form-control">
                                    <option value="" selected="true" disabled="true"> - </option>
                                    <?php foreach($area as $vArea){ ?>
                                    <option value="<?php echo $vArea['id'];?>" <?php echo ($data['id_area']==$vArea['id'] ? "selected" : "");?>><?php echo $vArea['area_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subrea Code</label>
                                <input type="text" name="subarea_code" value="<?php echo $data['subarea_code'];?>" parsley-trigger="change" required placeholder="Subarea Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Subrea Name</label>
                                <input type="text" name="subarea_name" value="<?php echo $data['subarea_name'];?>" parsley-trigger="change" required placeholder="Subrea Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Subrea Description</label>
                                <textarea name="subarea_description" parsley-trigger="change" required placeholder="Subrea Description" class="form-control"><?php echo $data['subarea_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="subarea_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['subarea_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['subarea_status']=="2"?"selected":"");?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('master-subarea'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>