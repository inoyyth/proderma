<?php
if ($data['so_discount_type'] == 'Fixed') {
    $discount_value = $data['so_discount_value'];
} else {
    $discount_value = (($data_product['grand_total'] * intval($data['so_discount_value'])) / 100);
    $discount_value2 = (($data_product['grand_total'] - $discount_value) * intval($data['so_discount_value2']) / 100);
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
    <img style="height: 70px;width:150px;" src="<?php echo base_url('assets/images/logo.png'); ?>">
    <div style="font-weight:bold;font-size: 10px;">PT. Whoto Indonesia Sejahtera</div>
    <div style="font-size: 10px;">Jl. Palem 8 Blok F No.1032 </div>
    <div style="font-size: 10px;">Jakamulya, Bekasi Selatan 17146</div>
    <div style="text-align: center;font-weight: bolder;font-size: 10px;">
        FAKTUR
    </div>
    <div style="margin-top: 10px;">
        <div style="float:left;width:48%;">
            <table style="width: 100%;" style="font-size:11px;" >
                <tr>
                    <td style="font-size:11px;width:25%;border:1px solid;">KEPADA YTH</td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-top:1px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;"><?php echo $data['customer_name']; ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-top:1px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;"><?php echo $data['customer_address']; ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-top:1px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">HP: <?php echo $data['customer_phone']; ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px;">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div style="float:right;width:48%;">
            <table style="width: 100%;" style="font-size:11px;" >
                <tr>
                    <td style="font-size:11px;width:25%;border:1px solid;">No.Faktur</td>
                    <td style="font-size:11px;width:75%;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">: <?php echo $data['no_faktur']; ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Tgl.Pemesanan</td>
                    <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;">: <?php echo tanggalan($data['so_date']); ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Tgl.Surat Jalan</td>
                    <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;">: <?php echo tanggalan($data['do_date']); ?></td>
                </tr> 
                <tr>
                    <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Tgl.Jatuh Tempo</td>
                    <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;">: 
                        <?php
                            if ($due_date['pay_date'] !== "0000-00-00") {
                                echo ($due_date['pay_date'] !== null ? tanggalan($due_date['pay_date']) : "-");
                            } else {
                                echo " -";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">No.NPWP</td>
                    <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;">:</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="clear: both;height:10px;"></div>
    <table style="width: 100%;" style="font-size:13px;" cellspacing="0" cellpadding="1">
        <tr>
            <th style="font-size:11px;width:25px;border:1px solid;">No.</th>
            <th style="font-size:11px;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">Kode</th>
            <th style="font-size:11px;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">NAMA BARANG</th>
            <th style="font-size:11px;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">Qty</th>
            <th style="font-size:11px;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">Harga @Rp</th>
            <th style="font-size:11px;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">Jumlah</th>
        </tr>
        <?php 
            $max_row=10;
            $total_product = count($list_product);
            $rest_row = $max_row - $total_product;
            foreach ($list_product as $k=>$v) { ?>
        <tr>
            <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;"><?php echo $k+1; ?>.</td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"><?php echo $v['product_code'];?></td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"><?php echo $v['product_name'];?></td>
            <td style="text-align:right;font-size:11px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($v['qty']);?></td>
            <td style="text-align:right;font-size:11px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($v['product_price']);?></td>
            <td style="text-align:right;font-size:11px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($v['SubTotal']);?></td>
        </tr>
        <?php
            }
            if ($rest_row > 0) {
                for($i=1;$i<=$rest_row;$i++) {
        ?>
        <tr>
            <td style="font-size:11px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;"><?php echo $i + $total_product; ?>.</td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"></td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"></td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"></td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"></td>
            <td style="font-size:11px;border-bottom:1px solid;border-right:1px solid;"></td>
        </tr>
        <?php
            } }
        ?>
        <tr style="text-align: right">
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Sub Total</td>
            <td colspan="3" style="font-size: 10px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($data_product['grand_total']);?></td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Disc.1 | <b><?php echo $data['so_discount_value'];?>%</b></td>
            <td colspan="2" style="font-size: 10px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($discount_value);?></td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Disc.2 | <b><?php echo $data['so_discount_value2'];?>%</b></td>
            <td colspan="3" style="font-size: 10px;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp($discount_value2);?></td>
        </tr>
        <tr style="text-align: left;font-size: 10px;">
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="text-align: left;font-size: 10px;">&nbsp;</td>
            <td style="font-size: 10px;border-bottom:1px solid;border-left:1px solid;border-right:1px solid;">Total</td>
            <td colspan="3" style="font-size: 10px;text-align:right;border-bottom:1px solid;border-right:1px solid;"><?php echo formatrp(((intval(($data_product['grand_total']) - (intval($discount_value)) - (intval($discount_value2)))))) ; ?></td>
        </tr>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td colspan="7" style="text-align: center;font-weight: bold;font-size: 10px;border:1px solid;"><?php echo terbilang(((intval($data_product['grand_total']) - intval($discount_value) - intval($discount_value2)))); ?></td>
        </tr>
    </table>
    <div class="col-lg-12" style="font-size: 10px;">
        <table>
            <tr>
                <td style="font-size:11px;">Payment Term</td>
                <td style="font-size:11px;">: <?php echo $data['payment_type']; ?></td>
            </tr>
            <tr>
                <td style="text-align: left;font-size: 10px;">NB</td>
                <td style="font-size:11px;">: Semua Product Sudah Termasuk Ppn 10%.</td>
            </tr>
        </table>
    </div>
    <div class="text-right">
        <p style="font-size:11px;text-align:right;"><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo date('d-m-Y');?></p>
    </div>
    <div class="text-left" style="line-height: 20%;font-size: 10px;">
        <p>Pembayaran ditransfers ke rekening kami: A/N PT.Whoto Indonesia Sejahtera</p>
        <table style="width: 100%;" style="font-size:13px;" cellspacing="0" cellpadding="1">
            <tr>
                <td style="width:50%;">
                    <table cellspacing="0" cellpadding="1">
                        <tr>
                            <td style="font-size:11px;">A/C 167.000.555.8555 (Mandiri cab.Taman Galaxy)</td>
                        </tr>
                        <tr>
                            <td style="font-size:11px;">A/C 577.079.4449 (BCA cab.Taman Galaxy)</td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;">
                    <table cellspacing="0" cellpadding="1" style="float:right;">
                        <tr>
                            <td style="font-size:11px;">A/C 1150.01.000110.306 (BRI cab.Taman Galaxy)</td>
                        </tr>
                        <tr>
                            <td style="font-size:11px;">A/C 488.3761.71 (BNI cab.Taman Galaxy)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="text-center" style="">
        <p style="border-bottom:2px solid;font-weight: bold;font-size:11px;text-align:center;">( TIDAK MENERIMA PEMBAYARAN DENGAN TUNAI ATAUPUN PEMBAYARAN SELAIN KE REKENING DIATAS)  </p>
    </div>
    <div style="font-size: 10px;font-size: 10px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;font-size:11px;">
                    Hormat Kami
                </td>
                <td style="width: 30%;text-align: center;font-size:11px;">
                    Yang Menerima Faktur
                </td>
            </tr>
            <tr style="height: 0px;">
                <td colspan="3" style="font-size:11px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;font-size:11px;">
                    <img src="<?php echo base_url($this->config->item('invoice_sign'));?>" style="height: 50px;">
                    <div>
                        (SALES MANAGER)
                    </div>
                </td>
                <td style="text-align: center;font-size:11px;">
                    <div style="margin-top: 50px;">
                        (.................................)
                     </div>
                </td>
            <tr>
                <td style="text-align: center;font-size:11px;">
                    &nbsp;
                </td>
                <td style="text-align: center;font-size:11px;">
                    &nbsp;
                </td>
            </tr>
        </table>
    </div>
    <div style="text-align: center;">
        <button class="no-print" onclick="printPage();">Print</button>
    </div>
</body>
<script>
    function printPage() {
        window.print();
    }
</script>