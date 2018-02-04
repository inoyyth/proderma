<div class="row">
    <form id="form-id" action="<?php echo base_url("master-payment-type-save"); ?>" method="post"  enctype="multipart/form-data" parsley-validate novalidate>
        <div class="col-md-6">
            <div class="block-web">
                <div class="porlets-content">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <input type="text" name="payment_type" id="payment_type" parsley-trigger="change" required placeholder="Payment Type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" name="termin_status" id="termin" value="N">Checked if this payment with termin</label>
                            </div>
                            <div id="termin-range-content"></div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="payment_type_description" parsley-trigger="change" required placeholder="Description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="payment_type_status" placeholder="Status" required class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url('master-payment-type'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    var html =  '<div class="form-group">' +
                '<label>Termin Range (days)</label>' +
                '<input type="text" name="termin_range" id="termin_range" parsley-trigger="change" placeholder="Input Range Used Number Only" class="form-control">' +
                '</div>';
    $('#termin').click(function(){
        if ($(this).is(':checked')) {
            $(this).val('Y');
            $("#termin-range-content").append(html);
        } else {
            $(this).val('N');
            $("#termin-range-content").empty(); 
        }
    });

    $("#form-id").on('keydown','#termin_range',function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $("#form-id").on('submit',function(e){
        if ($('#termin').is(':checked')) {
            if ($("#termin_range").val() === "") {
                alert('Pleas Fill Termin Range');
                return false;
            }
        } else {
            return true;
        }
    });

});
</script>