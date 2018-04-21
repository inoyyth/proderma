<div class="row">
    <form action="<?php echo base_url("employee-level-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-12">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>No.Produksi</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="No Produksi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tgl.Produksi</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Tgl.Produksi" class="form-control datepicker">
                            </div>
							<div class="form-group">
                                <label>Tgl.Expired</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Tgl.Expired" class="form-control datepicker">
                            </div>
                        </div>
						<div class="col-md-4">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Nama Product</label>
                                <select name="jabatan" parsley-trigger="change" required placeholder="Turunan" class="form-control">
									<option>Aspirin</option>
									<option>Bodrex</option>
									<option>Parasetamol</option>
								</select>
                            </div>
                            <div class="form-group">
                                <label>Turunan</label>
                                <select name="jabatan" parsley-trigger="change" required placeholder="Turunan" class="form-control">
									<option>Anak</option>
									<option>Dewasa</option>
									<option>Lansia</option>
								</select>
                            </div>
							<div class="form-group">
                                <label>Customer</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Customer" class="form-control">
                            </div>
                        </div>
						<div class="col-md-4">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="Qty" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pic</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="PIC" class="form-control">
                            </div>
							<div class="form-group">
                                <label>Label</label>
                                <input type="text" name="jabatan" parsley-trigger="change" required placeholder="PIC" class="form-control">
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
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Qty</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Qty" class="form-control">
										</div>
										<div class="form-group">
											<label>Qty</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Qty" class="form-control">
										</div>
										<div class="form-group">
											<label>Qty</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Qty" class="form-control">
										</div>
										<div class="form-group">
											<label>Qty</label>
											<input type="text" name="jabatan" parsley-trigger="change" required placeholder="Qty" class="form-control">
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