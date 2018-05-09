<style>
    body {
        font-family: "Calibri";
        letter-spacing: 2px;
        font-size: 12px;
    }
    @media print {
        .no-print, .no-print * { display: none !important; }
        font-family: "Calibri";
        letter-spacing: 4px;
        font-size: 12px;
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
    <table style="width: 100%;" style="font-size:12px;" cellspacing="0" cellpadding="1">
        <tr>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:12px;width: 25%;">Tanggal : </td>
                        <td style="font-size:12px;width: 75%;"> <?php echo tanggalan($data['so_date']); ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;">Nama ME :</td>
                        <td style="font-size:12px;">  <?php echo $data['employee_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;">Area : </td>
                        <td style="font-size:12px;"> <?php echo $data['area_name'] . '/' . $data['subarea_name']; ?></td>
                    </tr>   
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:12px;width: 25%;">No So : </td>
                        <td style="font-size:12px;width: 75%"> <?php echo $data['so_code']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;">Customer :</td>
                        <td style="font-size:12px;">  <?php echo $data['customer_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;">Telp : </td>
                        <td style="font-size:12px;"> <?php echo $data['customer_phone']; ?></td>
                    </tr> 
                    <tr>
                        <td style="font-size:12px;">Alamat : </td>
                        <td style="font-size:12px;"> <?php echo $data['customer_address']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </table>
    <br>
    <table style="width: 100%;" style="font-size: 10px;" cellspacing="0" border="1" cellpadding="1">
        <tr>
            <th style="font-size: 10px;">Kode</th>
            <th style="font-size: 10px;">Product</th>
            <th style="font-size: 10px;">Qty</th>
            <th style="font-size: 10px;">Price</th>
            <th style="font-size: 10px;">SubTotal</th>
            <th style="font-size: 10px;">Keterangan</th>
        </tr>
        <?php foreach($list_product as $k=>$v) {?>
        <tr>
            <td style="font-size: 10px;"><?php echo $v['product_code'];?></td>
            <td style="font-size: 10px;"><?php echo $v['product_name'];?></td>
            <td style="text-align:right;font-size: 10px;"><?php echo formatrp($v['qty']);?></td>
            <td style="text-align:right;font-size: 10px;"><?php echo formatrp($v['product_price']);?></td>
            <td style="text-align:right;font-size: 10px;"><?php echo formatrp($v['SubTotal']);?></td>
            <td style="font-size: 10px;"><?php echo $v['description'];?></td>
        </tr>
        <?php } ?>
					<tr>
    </table>
    <div style="text-align: right;padding-right: 30px;font-size: 10px;">
    <br>
        , <?php echo tanggalan(date('Y-m-d')); ?>
    </div>
    <br/>
    <center>
        <table style="font-size: 15px;" cellpadding="1">
            <tr>
                <td style="font-size:12px;width: 25%;text-align: center;">Dipesan Oleh</td>
                <td style="font-size:12px;width: 25%;text-align: center;">Menyetujui</td>
                <td style="font-size:12px;width: 25%;text-align: center;" colspan="2">Standart Pengiriman & Packing</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td style="font-size:12px;width: 25%;text-align: center;"> CHECK 1</td>
                <td style="font-size:12px;width: 25%;text-align: center;"> CHECK 2</td>
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