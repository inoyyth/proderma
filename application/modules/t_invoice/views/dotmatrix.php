<?php
if ($data['so_discount_type'] == 'Fixed') {
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
    <div style="font-weight:bold;font-size: 10px;">PT. Whoto Indonesia Sejahtera</div>
    <div style="font-size: 10px;">Jl. Palem 8 Blok F No.1032 </div>
    <div style="font-size: 10px;">Jakamulya, Bekasi Selatan 17146</div>
    <br>
    <div style="text-align: center;font-weight: bolder;font-size: 10px;">
        FAKTUR
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
                        <td style="font-size:10px;"><?php echo $data['customer_name']; ?></td>
                    </tr>
                    <tr>
                    <td style="font-size:10px;"><?php echo $data['customer_clinic']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;"><?php echo $data['customer_address']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;">HP: <?php echo $data['customer_phone']; ?></td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td style="font-size:10px;width: 25%;">No.Faktur : </td>
                        <td style="font-size:10px;width: 75%"> <?php echo $data['no_faktur']; ?></td>
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
            <th style="font-size:10px;">Harga @Rp</th>
            <th style="font-size:10px;">Jumlah</th>
        </tr>
        <?php 
            $max_row=10;
            $total_product = count($list_product);
            $rest_row = $max_row - $total_product;
            foreach ($list_product as $k=>$v) { ?>
        <tr>
            <td style="font-size:10px;"><?php echo $k+1; ?>.</td>
            <td style="font-size:10px;"><?php echo $v['product_code'];?></td>
            <td style="font-size:10px;"><?php echo $v['product_name'];?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['qty']);?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['product_price']);?></td>
            <td style="text-align:right;font-size:10px;"><?php echo formatrp($v['SubTotal']);?></td>
        </tr>
        <?php
            }
            if ($rest_row > 0) {
                for($i=1;$i<=$rest_row;$i++) {
        ?>
        <tr>
            <td style="font-size:10px;"><?php echo $i + $total_product; ?>.</td>
            <td style="font-size:10px;"></td>
            <td style="font-size:10px;"></td>
            <td style="font-size:10px;"></td>
            <td style="font-size:10px;"></td>
            <td style="font-size:10px;"></td>
        </tr>
        <?php
            } }
        ?>
        <tr style="text-align: right">
            <td colspan="3" style="text-align: left;font-size: 10px;">SubTotal</td>
            <td style="font-size: 10px;"><?php echo formatrp($data_product['total_item']);?></td>
            <td colspan="2" style="font-size: 10px;"><?php echo formatrp($data_product['grand_total']);?></td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td colspan="4" style="font-size: 10px;">Discount</td>
            <td colspan="2" style="font-size: 10px;"><?php echo formatrp($discount_value);?></td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td colspan="4" style="font-size: 10px;">Total</td>
            <td colspan="2" style="font-size: 10px;"><?php echo formatrp(((intval($data_product['grand_total']) - (intval($discount_value)))))   ; ?></td>
        </tr>
        <tr style="text-align: right;font-size: 10px;">
            <td style="font-size: 10px;">Terbilang</td>
            <td colspan="6" style="text-align: center;font-weight: bold;font-size: 10px;"><?php echo terbilang(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
        </tr>
    </table>
    <br>
    <div class="col-lg-12" style="font-size: 10px;">
        <table>
            <tr>
                <td style="font-size:10px;">Payment Term</td>
                <td style="font-size:10px;">: <?php echo $data['payment_type']; ?></td>
            </tr>
            <tr>
                <td style="text-align: left;font-size: 10px;">NB</td>
                <td style="font-size:10px;">: Semua Product Sudah Termasuk Ppn 10%.</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="text-right" style="padding-right: 10px;">
        <p style="font-size:10px;text-align:right;"><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo date('d-m-Y');?></p>
    </div>
    <div class="text-left" style="padding-left: 10px;line-height: 20%;font-size: 10px;">
        <p>Pembayaran ditransfers ke rekening kami:</p>
        <p>Bank Mandiri Cab.Taman Galaxy</p>
        <p>Rek no. 167.000.555.8555</p>
        <p>Bank BRI</p>
        <p>Rek no. 1150.01.000110.306</p>
        <p>Bank BCA</p>
        <p>Rek no. 577.079.4449</p>
        <p>Bank BNI</p>
        <p>Rek no.488.3761.71</p>
        <p>an Whoto Indonesia Sejahtera</p>
    </div>
    <div class="text-center" style="padding-right: 10px;padding-left: 10px;">
        <p style="border: 1px solid;font-weight: bold;font-size:10px;">( TIDAK MENERIMA PEMBAYARAN DENGAN TUNAI ATAUPUN PEMBAYARAN SELAIN KE REKENING DIATAS)  </p>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 10px;font-size: 10px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;font-size:10px;">
                    Hormat Kami
                </td>
                <td style="width: 30%;text-align: center;font-size:10px;">
                    Yang Menerima Faktur
                </td>
            </tr>
            <tr style="height: 50px;">
                <td colspan="3" style="font-size:10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;font-size:10px;">
                    (.................................)
                </td>
                <td style="text-align: center;font-size:10px;">
                     (.................................)
                </td>
            <tr>
                <td style="text-align: center;font-size:10px;">
                    &nbsp;
                </td>
                <td style="text-align: center;font-size:10px;">
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