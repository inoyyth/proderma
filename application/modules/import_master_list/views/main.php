<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Upload Form</h4>
            </div>
            <div class="widget-body">
                <form method="post" name="frmGroupUser" id="frmGroupUser" enctype="multipart/form-data">
                    <div class="col-xs-12" style="margin-top: 5px;">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input multiple="" name="excel_file" type="file" id="id-input-file-3" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 10px;">
                        <button type="submit" id="myButton" data-loading-text="Loading..." class="btn btn-primary btn-sm">Generate</button> 
                        <button type="button" class="btn btn-warning btn-sm" id="cancel-form">Cancel</button>
                        <a href="<?php echo site_url('import-master-list-template'); ?>" class="btn btn-success btn-sm">[Download Template]</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: false, //| true | large
            whitelist: 'xls|xlsx', //|jpg|jpeg
            blacklist: 'exe|php|zip'
                    //,icon_remove:null//set null, to hide remove/reset button
                    /**,before_change:function(files, dropped) {
                     //Check an example below
                     //or examples/file-upload.html
                     return true;
                     }*/
                    /**,before_remove : function() {
                     return true;
                     }*/
            ,
            preview_error: function (filename, error_code) {
                //console.log(filename);
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function () {
            //console.log(getFileExtension1($(this).data('ace_input_files')[0]['name']));
            var extention = getFileExtension1($(this).data('ace_input_files')[0]['name']);
            if(extention === "xlsx" || extention === "xls"){
                return true;
            } else {
                alert('file extention false !!!');
                $('#id-input-file-3').ace_file_input('reset_input');
                return false;
            }
        }).on('file.error.ace', function (e, info) {
            console.log(e);
        }).on('file.preview.ace', function (e, info) {
            //console.log(info);
            e.preventDefault();//to prevent preview
        });
    });
    
    function getFileExtension1(filename) {
        return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
    }
</script>