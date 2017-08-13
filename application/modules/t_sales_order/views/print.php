<div style="width: 200px;padding-left: 10px;padding-top: 10px;">
    <img style="width: 190px;" src="<?php echo base_url('assets/images/logo.png'); ?>">
    <br>
    <div style="text-align: center;font-size: 10px;">
        PT.WHOTO INDONESIA SEJAHTERA<br>
        Jl. Palem 8 Blok F No.1032 <br>
        Jakamulya Bekasi 17146
    </div>
</div>
<div style="text-align: center;">
    <div style="font-size: 16x;font-weight: bolder;"><u>SALES ORDER</u></div>
</div>
<br>
<div style="padding-left: 10px;padding-right: 10px;">
    <table>
        <td style="width: 550px;">
            <table>
                <tr>
                    <td style="width: 100px;">
                        NIP
                    </td>
                    <td>
                        : <?php echo $data['employee_nip']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        NAME
                    </td>
                    <td>
                        : <?php echo $data['employee_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        SO.CODE
                    </td>
                    <td>
                        : <?php echo $data['so_code']; ?>
                    </td>
                </tr>
            </table>
        <td>
        <td>
            <table>
                <tr>
                    <td style="width: 100px;">
                        CUST.CODE
                    </td>
                    <td>
                        : <?php echo $data['customer_code']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        CUST.NAME
                    </td>
                    <td>
                        : <?php echo $data['customer_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        SO.DATE
                    </td>
                    <td>
                        : <?php echo $data['so_date']; ?>
                    </td>
                </tr>
            </table>
        <td>
    </table>
</div>
<br>
<div style="padding-left: 10px;padding-right: 10px;">
    <p style="font-weight: bolder;"><u>List Product</u></p>
</div>
<div style="padding-left: 10px;padding-right: 10px;">
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach($data_product as $k=>$v) {?>
        <tr>
            <td><?php echo $v['product_code'];?></td>
            <td><?php echo $v['product_name'];?></td>
            <td><?php echo $v['qty'];?></td>
            <td><?php echo $v['product_price'];?></td>
            <td><?php echo $v['SubTotal'];?></td>
        </tr>
        <?php } ?>
    </table>
</div>