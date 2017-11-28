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
                        <td style="width: 70px;">
                            Nama
                        </td>
                        <td>
                            : <?php echo $data['customer_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Alamat
                        </td>
                        <td>
                            : <?php echo $data['customer_address']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telepon
                        </td>
                        <td>
                            : <?php echo $data['customer_phone']; ?>
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
                        <td style="width: 70px;">
                            Invoice Code
                        </td>
                        <td>
                            : <?php echo $data['invoice_code']; ?>
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
                            : <?php echo ($due_date['pay_date'] == null ? '-' : tanggalan($due_date['pay_date'])); ?>
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
    <div style="padding-left: 10px;padding-right: 10px;font-size: 12px;">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list_product as $k=>$v) {?>
                    <tr>
                        <td><?php echo $v['product_code'];?></td>
                        <td><?php echo $v['product_name'];?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['qty']);?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['product_price']);?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['SubTotal']);?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfooter>
                        <tr style="text-align: right">
                            <td colspan="3"><?php echo formatrp($data_product['total_item']);?></td>
                            <td>SubTotal</td>
                            <td><?php echo formatrp($data_product['grand_total']);?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td colspan="4">Discount</td>
                            <td><?php echo formatrp($discount_value);?></td>
                        </tr>
                        <!--<tr style="text-align: right">
                            <td colspan="4">Tax</td>
                            <td><?php echo formatrp($tax);?></td>
                        </tr>-->
                        <tr style="text-align: right">
                            <td colspan="4">Total</td>
                            <td><?php echo formatrp(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td>Terbilang</td>
                            <td colspan="4" style="text-align: center;font-weight: bold;"><?php echo terbilang(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
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
                        <td style="text-align: right;">NB</td>
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
        <p style="border: 1px solid;font-weight: bold;">( TIDAK MENERIMA PEMBAYARAN DENGAN TUNAI ATAUPUN PEMBAYARAN SELAIN KE REKENING DIATAS  </p>
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
                    Sales Manager
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