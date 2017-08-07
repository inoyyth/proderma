<div class="row">
    <form action="<?php echo base_url("master-employee-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="image1" src="<?php echo base_url($data['photo_path']); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $data['photo_path'];?>">
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" id="id-employee" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="employee_nip" value="<?php echo $data['employee_nip'];?>" parsley-trigger="change" required placeholder="NIP" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <select id="id-jabatan" name="id_jabatan" parsley-trigger="change" required placeholder="Position" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($jabatan as $kJabatan=>$vJabatan) { ?>
                                    <option value="<?php echo $vJabatan['id'];?>" <?php echo ($data['id_jabatan']==$vJabatan['id']?"selected":"");?>><?php echo $vJabatan['jabatan'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group" id="pass-field" style="display: none;">
                                <label>Password</label>
                                <input type="password" id="sales-password" name="sales_password" parsley-trigger="change" required placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="employee_name" value="<?php echo $data['employee_name'];?>" parsley-trigger="change" required placeholder="Full Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="employee_email" value="<?php echo $data['employee_email'];?>" parsley-trigger="change" required placeholder="Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="employee_phone" value="<?php echo $data['employee_phone'];?>" parsley-trigger="change" parsley-type="digits" required placeholder="Phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="employee_gender" parsley-trigger="change" required placeholder="Gender" class="form-control">
                                    <option value="F <?php echo ($data['employee_gender']=="F"?"selected":"");?>">Female</option>
                                    <option value="M" <?php echo ($data['employee_gender']=="M"?"selected":"");?>>Male</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="employee_status" placeholder="Status" required class="form-control">
                                    <option value="1" <?php echo ($data['employee_status']=="1"?"selected":"");?>>Aktif</option>
                                    <option value="2" <?php echo ($data['employee_status']=="2"?"selected":"");?>>Non Aktif</option>
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
    $(document).ready(function (){
       if($("#id-jabatan").val() == 1){
           var id_employee = $("#id-employee").val();
           $.ajax({
                type:"POST",
                url:"<?php echo base_url('md_employee/getPassEmployee');?>",
                dataType: "json",
                data: {id:id_employee},
                success: function(result){
                    console.log(result);
                }
            }).done(function (result){
                $("#sales-password").val(result.data.password);
                $("#pass-field").show();
            }).fail(function() {
                alert( "error" );
              });
       }
    });
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