<?php
if ($data['so_discount_type'] == 'Fixed') {
    $discount_value = $data['so_discount_value'];
} else {
    $discount_value = (($data_product['grand_total'] * intval($data['so_discount_value'])) / 100);
}

$tax = (($data_product['grand_total'] * 10) / 100);

?>
<style>
    @media screen {
        #printSection {
            display: none;
        }
    }
    @media print {
        body > *:not(#printSection) {
            display: none;
        }
        #printSection, #printSection * {
            visibility: visible;
        }
        #printSection {
            position:absolute;
            left:0;
            top:0;
			font-size: 9px;
        }
        #footer {
           position:fixed;
           left:0px;
           bottom:0px;
           height:100px;
           width:100%;
           background:#999;
        }
		@media print {
        .no-print, .no-print * { display: none !important; }
        font-family: "Calibri";
        letter-spacing: 4px;
        font-size: 12px;
        size: 5.5in 8.5in;
    }
    }
</style>
<div id="printThis" style="padding: 10px;text-align: justify;">
    <div style="width: 200px;padding-left: 10px;">
        <img style="width: 190px;" src="<?php echo base_url('assets/images/logo.png'); ?>">
        <br>
        <div style="text-align: center;font-size: 11px;">
            PT.WHOTO INDONESIA SEJAHTERA<br>
            Jl. Palem 8 Blok F No.1032 <br>
            Jakamulya, Bekasi Selatan 17146
        </div>
    </div>
    <div style="text-align: center;">
        <div style="font-size: 16x;font-weight: bolder;"><u>FAKTUR</u></div>
    </div>
<br>
    <div style="padding-left: 10px;padding-right: 10px;">
        <table>
            <td style="width: 600px;">
                <table>
                    <tr>
                        <td style="width: 70px;">
                            Kepada
                        </td>
                        <td>
                            YTH.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 70px;">
                            <?php echo $data['customer_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 70px;">
                            <?php echo $data['customer_clinic']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <?php echo $data['customer_address']; ?>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                            Hp: <?php echo $data['customer_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            &nbsp;
                        </td>
                    </tr>
                </table>
            <td>
            <td style="width: 350px;">
                <table>
					<tr>
                        <td style="width: 70px;">
                            No.Faktur
                        </td>
                        <td>
                            : <?php echo $data['no_faktur']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tgl.Pemesanan
                        </td>
                        <td>
                            : <?php echo tanggalan($data['so_date']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tgl.Surat Jalan
                        </td>
                        <td>
                            : <?php echo tanggalan($data['do_date']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tgl.Jatuh Temp
                        </td>
                        <td>
                            : <?php
                                if ($data['due_date'] !== "0000-00-00") {
                                    echo ($data['due_date'] !== null ? tanggalan($data['due_date']) : "-");
                                } else {
                                    echo " -";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            <td>
        </table>
    </div>
<br>
    <div style="padding-left: 10px;padding-right: 10px;">
        <p style="font-weight: bolder;"><u>List Product</u></p>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 12px;">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>NAMA BARANG</th>
                        <th>Qty</th>
                        <th>Harga @Rp</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $max_row=10;
                        $total_product = count($list_product);
                        $rest_row = $max_row - $total_product;
                        foreach ($list_product as $k=>$v) { ?>
                    <tr>
                        <td><?php echo $k+1; ?>.</td>
                        <td><?php echo $v['product_code'];?></td>
                        <td><?php echo $v['product_name'];?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['qty']);?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['product_price']);?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['SubTotal']);?></td>
                    </tr>
                    <?php
                        }
                        if ($rest_row > 0) {
                            for($i=1;$i<=$rest_row;$i++) {
                    ?>
                    <tr>
                        <td><?php echo $i + $total_product; ?>.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                        } }
                    ?>
                    </tbody>
                    <tfooter>
                        <tr style="text-align: right">
                            <td colspan="3" style="text-align: left;">SubTotal</td>
                            <td><?php echo formatrp($data_product['total_item']);?></td>
                            <td colspan="2"><?php echo formatrp($data_product['grand_total']);?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td colspan="4">Discount</td>
                            <td colspan="2"><?php echo formatrp($discount_value);?></td>
                        </tr>
                        <!--<tr style="text-align: right">
                            <td colspan="4">Tax</td>
                            <td colspan="2"><?php echo formatrp($tax);?></td>
                        </tr>-->
                        <tr style="text-align: right">
                            <td colspan="4">Total</td>
                            <td colspan="2"><?php echo formatrp(((intval($data_product['grand_total']) - (intval($discount_value)))))   ; ?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td>Terbilang</td>
                            <td colspan="6" style="text-align: center;font-weight: bold;"><?php echo terbilang(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
                        </tr>
                    </tfooter>
                </table>    
            </div>
            <div class="col-lg-12">
                <table>
                    <tr>
                        <td>Payment Term</td>
                        <td>: <?php echo $data['payment_type']; ?></td>
                    </tr>
					<tr>
                        <td style="text-align: left;">NB</td>
                        <td>: Semua Product Sudah Termasuk Ppn 10%.</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="text-right" style="padding-right: 10px;">
        <p><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo date('d-m-Y');?></p>
    </div>
    <div class="text-left" style="padding-left: 10px;line-height: 20%;">
        <p>Pembayaran ditransfers ke rekening kami:</p>
		<br>
        <p>Bank Mandiri Cab.Taman Galaxy</p>
		<br>
        <p>Rek no. 167.000.555.8555</p>
		<br>
        <p>Bank BRI</p>
		<br>
        <p>Rek no. 1150.01.000110.306</p>
		<br>
        <p>Bank BCA</p>
		<br>
        <p>Rek no. 577.079.4449</p>
		<br>
        <p>Bank BNI</p>
		<br>
        <p>Rek no.488.3761.71</p>
		<br>
        <p>an Whoto Indonesia Sejahtera</p>
		<br>
    </div>
    <div class="text-center" style="padding-right: 10px;padding-left: 10px;">
        <p style="border: 1px solid;font-weight: bold;">( TIDAK MENERIMA PEMBAYARAN DENGAN TUNAI ATAUPUN PEMBAYARAN SELAIN KE REKENING DIATAS)  </p>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 12px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;">
                    Hormat Kami
                </td>
                <td style="width: 30%;text-align: center;">
                    Yang Menerima Faktur
                </td>
            </tr>
            <tr style="height: 50px;">
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    (.................................)
                </td>
                <td style="text-align: center;">
                     (.................................)
                </td>
            <tr>
                <td style="text-align: center;">
                    &nbsp;
                </td>
                <td style="text-align: center;">
                    &nbsp;
                </td>
            </tr>
        </table>
    </div>
</div>
<br>
<br>
<div class="text-center">
    <button id="btnPrint" class="btn btn-sm btn-primary">PRINT</button>
</div>
<script>
    document.getElementById("btnPrint").onclick = function () {
        //printElement(document.getElementById("printThis"));
        //window.print();
        printDiv('printThis');
    }
    function printElement(elem, append, delimiter) {
        var domClone = elem.cloneNode(true);
        var $printSection = document.getElementById("printSection");
        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }
        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof (delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof (delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }
        $printSection.appendChild(domClone);
    }
    function printDiv(div) {
        // Create and insert new print section
        var elem = document.getElementById(div);
        var domClone = elem.cloneNode(true);
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        $printSection.appendChild(domClone);
        document.body.insertBefore($printSection, document.body.firstChild);
        window.print();
        // Clean up print section for future use
        var oldElem = document.getElementById("printSection");
        if (oldElem != null) {
            oldElem.parentNode.removeChild(oldElem);
        }
        //oldElem.remove() not supported by IE
        return true;
    }
    
</script>