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
    <div style="font-weight:bold;font-size: 10px;">PT. Whoto Indonesia Sejahtera</div>
    <div style="font-size: 10px;">Jl. Palem 8 Blok F No.1032 </div>
    <div style="font-size: 10px;">Jakamulya, Bekasi Selatan 17146</div>
    <br>
    <div style="text-align: center;font-weight: bolder;font-size: 10px;">
        SURAT JALAN
    </div>
    <br>
    <table style="width: 100%;" style="font-size:10px;" cellspacing="0" cellpadding="1">
        <tr>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:10px;width: 25%;">KEPADA YTH</td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;"><?php echo $customer['customer_name']; ?></td>
                    </tr>
                    <tr>
                    <td style="font-size:10px;"><?php echo $customer['customer_clinic']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;"><?php echo $customer['customer_address']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;">HP: <?php echo $customer['customer_phone']; ?></td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:10px;width: 25%;">No.Faktur : </td>
                        <td style="font-size:10px;width: 75%"> <?php echo $data['do_code']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;">Tgl.Pemesanan :</td>
                        <td style="font-size:10px;">  <?php echo tanggalan($data['so_date']); ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;">Tgl.Surat Jalan : </td>
                        <td style="font-size:10px;"> <?php echo tanggalan($data['do_date']); ?></td>
                    </tr> 
                    <tr>
                        <td style="font-size:10px;">Tgl.Jatuh Tempo : </td>
                        <td style="font-size:10px;"> 
                            <?php
                                if ($due_date['pay_date'] !== "0000-00-00") {
                                    echo ($due_date['pay_date'] !== null ? tanggalan($due_date['pay_date']) : "-");
                                } else {
                                    echo " -";
                                }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </table>
    <br>
    <table style="width: 100%;" style="font-size:13px;" cellspacing="0" border="1" cellpadding="1">
        <tr>
            <th style="font-size:10px;">No.</th>
            <th style="font-size:10px;">Kode</th>
            <th style="font-size:10px;">NAMA BARANG</th>
            <th style="font-size:10px;">Qty</th>
            <th style="font-size:10px;">Bonus</th>
            <th style="font-size:10px;">Total</th>
        </tr>
        <?php 
            $total = 0;
            $max_row=10;
            $total_product = count($list_product);
            $rest_row = $max_row - $total_product;
            foreach($list_product as $k=>$v) {
                $total = $total+$v['qty']+$v['bonus_item']
        ?>
        <tr>
            <td style="text-align:left;font-size:10px;"><?php echo $k+1;?></td>
            <td style="text-align:left;font-size:10px;"><?php echo $v['product_code'];?></td>
            <td style="text-align:left;font-size:10px;"><?php echo $v['product_name'];?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['qty']);?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['bonus_item']);?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['qty'] + $v['bonus_item']);?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3" style="text-align:right;font-size:10px;">Total</td>
            <td colspan="3" style="text-align:right;font-size:10px;"><?php echo formatrp($total);?> Pcs</td>
        </tr>
    </table>
    <br>
    <div class="text-right" style="padding-right: 10px;font-size: 10px;text-align:right;">
        <p><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo tanggalan(date('Y-m-d'));?></p>
    </div>
    <br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 10px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;font-size: 10px;">
                    Tanda Terima
                </td>
                <td style="width: 30%;text-align: center;font-size: 10px;">
                    Pengirim
                </td>
            </tr>
            <tr style="height: 50px;">
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;font-size: 10px;">
                    (.................................)
                </td>
                <td style="text-align: center;font-size: 10px;">
                     (.................................)
                </td>
        </table>
    </div>
    <br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 10px;">
        <p style="width: 400px;border: 1px solid;text-align: justify;padding: 2px;font-weight: bold;">
            Note: Barang jika sudah di terima harap segera dicek,
            dan jika ada kerusakan harus segera di laporkan
            kepada marketing yang bersangkutan. <br>
            Apabila lewat dari 3 (tiga) hari dari barang yang sudah diterima,
            kami tidak menerima komplain, dianggap tidak ada masalah.<br>
            Dan kami tidak menerima retur diateas jangka waktu 3 (tiga) hari setelah barang diterima
        </p>
    </div>
</body>
<script>
    function printPage() {
        window.print();
    }
</script>