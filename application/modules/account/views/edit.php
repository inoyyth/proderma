<div class="row">
    <form action="<?php echo base_url("user-management-save"); ?>" method="post"  enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form Update Profile</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><button class="btn btn-primary btn-sm pull-left" type="submit">Submit</button>
                            <a href="<?php echo base_url('user-management'); ?>" class="btn btn-default pull-right">Cancel</a></li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                            <img id="image1" src="<?php echo (!empty($detail['path_foto']) ? cloudinary_url($detail['path_foto'].".png", array( "alt" => "User Image" )) : base_url('assets/images/user_icon.png')); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $detail['path_foto']; ?>">
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo $detail['username']; ?>" parsley-trigger="change" required placeholder="Isi Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" value="<?php echo $this->encrypt->decode($detail['password']); ?>" parsley-trigger="change" required placeholder="Isi Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="nama_lengkap" value="<?php echo $detail['nama_lengkap']; ?>" parsley-trigger="change" required placeholder="Isi Nama Lengkap" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="text" name="no_telp" value="<?php echo $detail['no_telp']; ?>" data-parsley-trigger="change" data-parsley-type="digits" required placeholder="Isi No Telepon" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $detail['email']; ?>" data-parsley-trigger="change" data-parsley-type="email" required placeholder="Isi Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" placeholder="Pilih Status" required class="form-control">
                                    <option value="1" <?php echo (isset($detail['status']) && $detail['status'] == '1' ? "selected" : "selected"); ?>>Aktif</option>
                                    <option value="2" <?php echo (isset($detail['status']) && $detail['status'] == '2' ? "selected" : ""); ?>>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        
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