<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Product <small>Category</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a href="<?php echo base_url('product-category-tambah');?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Add</a></li>
                <li><a target="_blank" href="<?php echo base_url('product-category-pdf/?template=table_pdf&name=product_category');?>" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Print</a></li>
                <li><a href="<?php echo base_url('product-category-excel/?template=table_excel&name=product_category');?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Code</th>
                                <th>Category Name</th>
                                <th>Category Status</th>
                                <th class="text-center" style="width: 200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($data) < 1) {
                                echo"<tr><td class='text-center' colspan='10'>-No Data Found-</td></tr>";
                            } else {
                                foreach ($data as $k => $v) {
                                    ?>
                                    <tr>
                                        <td><?php echo intval($this->uri->segment(2) + ($k + 1)); ?></td>
                                        <td><?php echo $v['product_category_code']; ?></td>
                                        <td><?php echo $v['product_category_name']; ?></td>
                                        <td><?php echo get_status($v['product_category_status']); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url('product-category-edit-' . $v['id']); ?>" class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Edit</a>
                                            <a href="<?php echo base_url('product-category-delete-' . $v['id']); ?>" onclick="return confirm('Sure to Delete ?');" class="btn btn-sm btn-danger"><i class="fa fa-edit"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <form id="form1" method="post" action="<?php echo base_url('product-category'); ?>">
                            <tr>
                                <td>#</td>
                                <td>
                                    <input class="form-control input-sm" name="product_category_code" class="form-control" value="<?php echo (isset($sr_data['product_category_code']) ? $sr_data['product_category_code'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm" name="product_category_name" class="form-control" value="<?php echo (isset($sr_data['product_category_name']) ? $sr_data['product_category_name'] : ""); ?>" type="text" onkeyup="javascript:if (event.keyCode == 13) {
                                                submit_search('form1');
                                            } else {
                                                return false;
                                            }
                                            ;"/>
                                </td>
                                <td>
                                    <select class="form-control input-sm" style="margin-top: 5px;" name="product_category_status" onchange="submit_search('form1');">                         
                                        <option value=""></option>
                                        <?php foreach($params_status as $kStatus=>$vStatus){ ?>
                                        <option value="<?php echo $vStatus['code'];?>" <?php echo (isset($sr_data['product_category_status']) && $sr_data['product_category_status']==$vStatus['code']?"selected":"");?>><?php echo $vStatus['value'];?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            <td>&nbsp;</td>
                            </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 pull-left text-left">	
                    <select class="form-control input-sm" name="page" onchange="submit_search('form1');"/>
                    <option value="10" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "10" ? "selected" : ""); ?>>10</option>
                    <option value="25" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "25" ? "selected" : ""); ?>>25</option>
                    <option value="50" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "50" ? "selected" : ""); ?>>50</option>
                    <option value="100" <?php echo (isset($sr_data['page']) && $sr_data['page'] == "100" ? "selected" : ""); ?>>100</option>
                    </select>
                </div>
                </form>
                <div class="col-lg-3 pull-left">
                    <?php echo generate_page_count_table($this->uri->segment(2),$sr_data['page'],$total_rows);?>
                </div>
                <div class="col-lg-8 pull-right text-right">	
                    <?php echo $paging; ?>
                </div>
            </div>
        </div>
    </div>
</div>