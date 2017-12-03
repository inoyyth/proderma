<div class="row">
    <form action="<?php echo base_url("branch-target-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Branch</label>
                                <select name="id_branch" parsley-trigger="change" required placeholder="Branch" class="form-control">
                                    <option value="" selected disabled> select branch </option>
                                    <?php foreach ($branch as $kBranch=>$vBranch) {?>
                                        <option value="<?php echo $vBranch['id'];?>"><?php echo $vBranch['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Month</label>
                                <select name="month_target" placeholder="Month Target" required class="form-control">
                                    <option value="" selected disabled> select month </option>
                                    <?php 
                                        $bln = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                                        foreach ($bln as $kBln=>$vBln) {
                                    ?>
                                    <option value="<?php echo $kBln;?>"><?php echo $vBln;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Year</label>
                                <select name="year_target" placeholder="Year Target" required class="form-control">
                                    <option value="" selected disabled> select year </option>
                                    <?php 
                                        $year = date('Y');
                                        for($i=date('Y'); $i <= $year+1; $i++) {
                                    ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input name="value_target" parsley-trigger="change" required placeholder="Target Value" class="form-control number">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('branch-target'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>