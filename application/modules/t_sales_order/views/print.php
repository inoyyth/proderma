<?php
if ($data['so_discount_type'] == 1) {
    $discount_value = $data['so_discount_value'];
} else {
    $discount_value = (($data_product['grand_total'] * intval($data['so_discount_value'])) / 100);
}

$tax = (($data_product['grand_total'] * 10) / 100);

?>
<style>
    .table > thead > tr > td {
        padding: 0px;
    }
    .print_body {
        font-family: Calibri, sans-serif; 
    }
    @media screen {
        #printSection {
            display: none;
        }
    }
    @media print {
        body > *:not(#printSection) {
            display: none;
            font-family: Calibri, sans-serif; 
        }
        #printSection, #printSection * {
            visibility: visible;
        }
        #printSection {
            position:absolute;
            left:0;
            top:0;
			font-size: 9px;
            font-family: Calibri, sans-serif; 
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
<div class="print_body">
<div id="printThis">
    <div style="width: 150px;padding-left: 10px;padding-top: 2px;">
        <img style="width: 120px;margin-left:7px" src="<?php echo base_url('assets/images/logo.png'); ?>">
        <br>
        <div style="text-align: left;font-size: 9px;">
            PT.WHOTO INDONESIA SEJAHTERA<br>
            Jl. Palem 8 Blok F No.1032 <br>
            Jakamulya, Bekasi Selatan 17146
        </div>
    </div>
    <div style="text-align: center;">
        <div style="font-size: 9x;"><u>PURCHASE ORDER</u></div>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 9px;">
        <table>
            <td style="width: 450px;">
                <table border="1">
                    <tr>
                        <td style="width: 70px;">
                            Tanggal
                        </td>
                        <td>
                            &nbsp;<?php echo tanggalan($data['so_date']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nama ME
                        </td>
                        <td>
                            &nbsp;<?php echo $data['employee_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Area
                        </td>
                        <td>
                            &nbsp;<?php echo $data['area_name'] . '/' . $data['subarea_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NPWP
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </table>
            <td>
            <td style="width: 450px;">
                <table border="1" style="float: right;">
                    <tr>
                        <td style="width: 70px;">
                            No. SO
                        </td>
                        <td>
                            &nbsp;<?php echo $data['so_code']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CUSTOMER
                        </td>
                        <td>
                            &nbsp;<?php echo $data['customer_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            TELP
                        </td>
                        <td>
                            &nbsp;<?php echo $data['customer_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Alamat
                        </td>
                        <td>
                            &nbsp;<?php echo $data['customer_address']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nama NPWP
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </table>
            <td>
        </table>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 9px;margin-top: 5px;">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th height="5" style="padding:0px;">No</th>
                        <th height="5" style="padding:0px;">NAMA PRODUK+UKURAN</th>
                        <th height="5" style="padding:0px;">HARGA</th>
                        <th height="5" style="padding:0px;">JMLH</th>
                        <th height="5" style="padding:0px;">BNS</th>
                        <th height="5" style="padding:0px;">TTL QTY</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $max_row = 10;
                            $total_product = count($list_product);
                            $rest_row = $max_row - $total_product;
                            foreach($list_product as $k=>$v) { 
                        ?>
                        <tr>
                            <td style="padding:0px;"><?php echo $k+1; ?>.</td>
                            <td style="padding:0px;"><?php echo $v['product_name'];?></td>
                            <td style="text-align:right;padding:0px;"><?php echo formatrp($v['product_price']);?></td>
                            <td style="text-align:right;padding:0px;"><?php echo formatrp($v['qty']);?></td>
                            <td style="text-align:right;padding:0px;"><?php echo formatrp($v['bonus_item']);?></td>
                            <td style="text-align:right;padding:0px;"><?php echo formatrp($v['qty'] + $v['bonus_item']);?></td>
                        </tr>
                        <?php
                            }
                            if ($rest_row > 0) {
                            for($i=1;$i<=$rest_row;$i++) {
                        ?>
                        <!-- <tr>
                            <td style="font-size:9px;"><?php echo $i + $total_product; ?>.</td>
                            <td style="font-size:9px;"></td>
                            <td style="text-align:right;font-size:9px;"></td>
                            <td style="text-align:right;font-size:9px;"></td>
                            <td style="text-align:right;font-size:9px;"></td>
                            <td style="text-align:right;font-size:9px;"></td>
                        </tr> -->
                        <?php } } ?>
                        <tr>
                            <td colspan="2" style="text-align:center;font-size:9px;padding:0px;">Grand Total</td>
                            <td colspan="4" style="text-align:right;font-size:9px;padding:0px;"><?php echo formatrp($data_product['grand_total']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;font-size:9px;padding:0px;">Discount (+)</td>
                            <td colspan="4" style="text-align:right;font-size:9px;padding:0px;"><?php echo formatrp($discount_value); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;font-size:9px;padding:0px;">Total</td>
                            <td colspan="4" style="text-align:right;font-size:9px;padding:0px;"><?php echo formatrp(((intval($data_product['grand_total']) - intval($discount_value)))); ?></td>
                        </tr>
                    </tbody>
                </table>    
            </div>
            <div class="col-lg-12" style="font-size: 9px;margin-top:-1px;">
			    * Semua Product Sudah Termasuk Ppn 10%.
			</div>
            <div class="col-lg-12" style="font-size: 9px;margin-top:5px;">
                <p style="font-weight: bolder;">Keterangan:</p>
                <p style="margin-top:-10px;">-</p>
            </div>
        </div>
    </div>
    <div class="text-right" style="padding-right: 10px;font-size: 9px;">
        <p><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo tanggalan(date('Y-m-d'));?></p>
    </div>
    <br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 9px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;">
                    Dipesan Oleh
                </td>
                <td style="width: 30%;text-align: center;">
                    Menyetujui
                </td>
                <td style="width: 60%;text-align: center;">
                    Standart Pengiriman & Packing
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    &nbsp;
                </td>
                <td style="text-align: center;">
                    &nbsp;
                </td>
                <td style="text-align: center;">
                    <table style="width: 100%;">
                        <td style="text-align: center;font-size:9px;">CHECK1</td>
                        <td style="text-align: center;font-size:9px;">CHECK2</td>
                    </table>
                </td>
            </tr>
            <tr style="height: 25px;">
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    (.................................)
                </td>
                <td style="text-align: center;">
                     (.................................)
                </td>
                <td style="text-align: center;">
                    <table style="width: 100%;">
                        <td style="text-align: center;"> (.................................)</td>
                        <td style="text-align: center;"> (.................................)</td>
                    </table>
                </td>
                <tr>
                <td style="text-align: center;">
                    ME
                </td>
                <td style="text-align: center;">
                    SPV
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