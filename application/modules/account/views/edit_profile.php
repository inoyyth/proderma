<div class="row">
    <form action="<?php echo site_url("user-management-save-profile"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> </div>
                    <h3 class="content-header">User Management</h3>
                </div>
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                            <img id="image1" src="<?php echo (!empty($detail['path_foto']) ? $detail['path_foto'] : site_url('assets/images/account/user_icon.png')); ?>" alt="..." class="img-circle img-responsive">
                            <input type="file" onchange="readURL(this);" class="form-control input-sm" name="path_foto" id="path_foto">
                            <input type="hidden" name="image_hidden" value="<?php echo $detail['path_foto']; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" readonly="true" value="<?php echo $detail['username']; ?>" parsley-trigger="change" required placeholder="Isi Username" class="form-control">
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
                                <input type="text" name="no_telp" value="<?php echo $detail['no_telp']; ?>" parsley-trigger="change" parsley-type="digits" required placeholder="Isi No Telepon" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $detail['email']; ?>" parsley-trigger="change" parsley-type="email" required placeholder="Isi Email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('user-management'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {

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