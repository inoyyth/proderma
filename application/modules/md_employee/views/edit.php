<div class="row">
    <form id="form-employee" action="<?php echo base_url("master-employee-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-8">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <label style="background-color:#438EB9;text-align:center;color:#fff;width:100%;">Profile Image</label>
                                <img id="image1" width="250px" height="170" src="<?php echo base_url($data['photo_path']); ?>" alt="..." class="img-rounded img-responsive">
                                <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                                <input type="hidden" name="image_hidden" value="<?php echo $data['photo_path'];?>">
                            </div>
                            <div style="margin-top:20px;">
                                <label style="background-color:#438EB9;text-align:center;color:#fff;width:100%;">Signature</label>
                                <img id="image2" width="250px" height="170" src="<?php echo base_url($data['signature_path']); ?>" alt="..." class="img-rounded img-responsive">
                                <input type="file" onchange="readURL2(this);" class="form-control input-sm" name="path_signature" id="path_signature">
                                <input type="hidden" name="signature_hidden" value="<?php echo $data['signature_path'];?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" id="id-employee" value="<?php echo $data['id'];?>" name="id">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="employee_nip" value="<?php echo $data['employee_nip'];?>" parsley-trigger="change" required placeholder="NIP" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="employee_name" value="<?php echo $data['employee_name'];?>" parsley-trigger="change" required placeholder="Full Name" class="form-control">
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
                                <input type="password" id="sales-password" name="sales_password" parsley-trigger="change" placeholder="Password" class="form-control">
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
                            <?php if($this->sessionGlobal['super_admin'] == "2"){ ?>
                            <div class="form-group">
                                <label>Branch Office</label>
                                <select name="id_branch" parsley-trigger="change" required placeholder="Branch Office" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($branch as $kBranch=>$vBranch) { ?>
                                    <option value="<?php echo $vBranch['id'];?>" <?php echo ($data['id_branch']==$vBranch['id'] ? "selected" : "");?>><?php echo $vBranch['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php } ?>
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
        if($("#id-jabatan").val() == 1 || $("#id-jabatan").val() == 6){
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
       
        $("#id-jabatan").change(function(){
            if ($(this).val() == 1 || $("#id-jabatan").val() == 6) {
                $("#pass-field").show();
            } else {
                $("#pass-field").hide();
            }
        });
        
        $("#form-employee").submit(function(){
            if ($("#id-jabatan").val() == 1 || $("#id-jabatan").val() == 6) {
                if ($("#sales-password").val() === "") {
                    alert('PASSWORD IS REQUIRED!!!');
                    return false;
                }
            }
        });
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
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image2')
                        .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } 
</script>