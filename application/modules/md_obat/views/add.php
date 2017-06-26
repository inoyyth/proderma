<div class="row">
    <form action="<?php echo base_url("employee-level-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Kode Obat</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Kode Obat" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Nama Obat" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-lg-12">
							<fieldset>
								<legend>Komposisi:</legend>
								<div class="content">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Bahan Baku 1</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Bahan Baku 1" class="form-control">
										</div>
										<div class="form-group">
											<label>Bahan Baku 2</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Bahan Baku 2" class="form-control">
										</div>
										<div class="form-group">
											<label>Bahan Baku 3</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Bahan Baku 3" class="form-control">
										</div>
										<div class="form-group">
											<label>Bahan Baku 4</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Bahan Baku 4" class="form-control">
										</div>
										<div class="form-group">
											<label>Bahan Baku 5</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Bahan Baku 5" class="form-control">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Kemasan</label>
											<select name="jabatan" parsley-trigger="change" required placeholder="Kemasan" class="form-control">
												<option>Botol</option>
												<option>Sachet</option>
											</select>
										</div>
										<div class="form-group">
											<label>Label</label>
											<select name="jabatan" parsley-trigger="change" required placeholder="Label" class="form-control">
												<option>LBL-001</option>
												<option>LBL-002</option>
											</select>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="<?php echo site_url('employee-level'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>