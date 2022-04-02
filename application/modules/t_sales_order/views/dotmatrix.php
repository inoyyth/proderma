<?php
if ($data['so_discount_type'] == 1) {
    $discount_value = $data['so_discount_value'];
} else {
    $discount_value = (($data_product['grand_total'] * intval($data['so_discount_value'])) / 100);
}

$tax = (($data_product['grand_total'] * 10) / 100);

?>
<style>
    html, body {
        /*width: 5.5in; /* was 8.5in */
        /*height: 8.5in; /* was 5.5in */
        display: block;
        font-family: "Calibri";
        /*font-size: auto; NOT A VALID PROPERTY */
    }
    @media print {
        .no-print, .no-print * { display: none !important; }
        font-family: "Calibri";
        letter-spacing: 4px;
        font-size: 15px;
        size: auto;
        table {
            border-width: thin;
            border-spacing: 2px;
            border-style: none;
            border-color: black;
        }
    }
    @page {
        size: auto /* . Random dot? */;
    }
</style>
<body>
    <div style="font-weight:bold;">PT. Whoto Indonesia Sejahtera</div>
    <div>Jl. Palem 8 Blok F No.1032 </div>
    <div>Jakamulya, Bekasi Selatan 17146</div>
    <br>
    <div style="text-align: center;font-weight: bolder;">
        == PURCHASE ORDER ==
    </div>
    <br>
    <table style="width: 100%;" style="font-size:14px;" cellspacing="0" cellpadding="1">
        <tr>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:14px;width: 25%;">Tanggal : </td>
                        <td style="font-size:14px;width: 75%;"> <?php echo tanggalan($data['so_date']); ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">Nama ME :</td>
                        <td style="font-size:14px;">  <?php echo $data['employee_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">Area : </td>
                        <td style="font-size:14px;"> <?php echo $data['area_name'] . '/' . $data['subarea_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">NPWP : </td>
                        <td style="font-size:14px;"></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">NAMA NPWP : </td>
                        <td style="font-size:14px;"></td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:14px;width: 25%;">No PO : </td>
                        <td style="font-size:14px;width: 75%"> <?php echo $data['so_code']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">Customer :</td>
                        <td style="font-size:14px;">  <?php echo $data['customer_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;">Telp : </td>
                        <td style="font-size:14px;"> <?php echo $data['customer_phone']; ?></td>
                    </tr> 
                    <tr>
                        <td style="font-size:14px;">Alamat : </td>
                        <td style="font-size:14px;"> <?php echo $data['customer_address']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </table>
    <br>
    <table style="width: 100%;" style="font-size:13px;" cellspacing="0" border="1" cellpadding="1">
        <tr>
            <th style="font-size:12px;">No.</th>
            <th style="font-size:12px;">NAMA PRODUK+UKURAN</th>
            <th style="font-size:12px;">HARGA</th>
            <th style="font-size:12px;">JMLH</th>
            <th style="font-size:12px;">BNS</th>
            <th style="font-size:12px;">TTL QTY</th>
        </tr>
        <?php
            $total_product = count($list_product);
            foreach($list_product as $k=>$v) { 
        ?>
        <tr>
            <td style="font-size:12px;"><?php echo $k+1; ?>.</td>
            <td style="font-size:12px;"><?php echo $v['product_name'];?></td>
            <td style="text-align:right;font-size:12px;"><?php echo formatrp($v['product_price']);?></td>
            <td style="text-align:right;font-size:12px;"><?php echo formatrp($v['qty']);?></td>
            <td style="text-align:right;font-size:12px;"><?php echo formatrp($v['bonus_item']);?></td>
            <td style="text-align:right;font-size:12px;"><?php echo formatrp($v['qty'] + $v['bonus_item']);?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2" style="text-align:center;font-size:12px;">Grand Total</td>
            <td colspan="4" style="text-align:right;font-size:12px;"><?php echo formatrp($data_product['grand_total']); ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;font-size:12px;">Discount (+)</td>
            <td colspan="4" style="text-align:right;font-size:12px;"><?php echo formatrp($discount_value); ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;font-size:12px;">Total</td>
            <td colspan="4" style="text-align:right;font-size:12px;"><?php echo formatrp(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
        </tr>
    </table>
    <div class="col-lg-12" style="font-size: 12px;margin-top:-1px;">
			* Semua Product Sudah Termasuk Ppn 10%.
			</div>
            <div class="col-lg-12" style="font-size: 12px;margin-top:5px;">
                <p style="font-weight: bolder;">Keterangan:</p>
                <p style="margin-top:-10px;">-</p>
			</div>
    <div style="text-align: right;padding-right: 30px;font-size:12px;">
        , <?php echo tanggalan(date('Y-m-d')); ?>
    </div>
    <br/>
    <center>
        <table style="font-size: 15px;" cellpadding="1">
            <tr>
                <td style="font-size:14px;width: 25%;text-align: center;">Dipesan Oleh</td>
                <td style="font-size:14px;width: 25%;text-align: center;">Menyetujui</td>
                <td style="font-size:14px;width: 25%;text-align: center;" colspan="2">Standart Pengiriman & Packing</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td style="font-size:14px;width: 25%;text-align: center;"> CHECK 1</td>
                <td style="font-size:14px;width: 25%;text-align: center;"> CHECK 2</td>
            </tr>
            <?php for($i=1;$i<10;$i++) { ?>
            <tr>
                <td colspan="4"></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="width: 25%;text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br> ME </td>
                <td style="width: 25%;text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br> SPV </td>
                <td style="width: 25%;text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br>&nbsp;</td>
                <td style="width: 25%;text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br>&nbsp;</td>
            </tr>
        </table>
        <div style="text-align: center;">
            <button class="no-print" onclick="printPage();">Print</button>
        </div>
    </center>
</body>
<script>
    function printPage() {
        window.print();
    }
</script>