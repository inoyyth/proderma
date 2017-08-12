<div class="row">
    <form action="<?php echo base_url("master-employee-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="image1" width="250px" height="170px" src="<?php echo base_url('assets/images/account/user_icon.png'); ?>" alt="..." class="img-rounded img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="employee_nip" parsley-trigger="change" required placeholder="NIP" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="employee_name" parsley-trigger="change" required placeholder="Full Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <select name="id_jabatan" parsley-trigger="change" required placeholder="Position" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($jabatan as $kJabatan=>$vJabatan) { ?>
                                    <option value="<?php echo $vJabatan['id'];?>"><?php echo $vJabatan['jabatan'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="employee_email" parsley-trigger="change" required placeholder="Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="employee_phone" parsley-trigger="change" parsley-type="digits" required placeholder="Phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="employee_gender" parsley-trigger="change" required placeholder="Gender" class="form-control">
                                    <option value="F">Female</option>
                                    <option value="M">Male</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="employee_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('master-employee'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image1')
                        .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } 
</script>