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
			font-size: 10px;
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
            <td style="width: 450px;">
                <table>
                    <tr>
                        <td style="width: 80px;">
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
                        <td style="width: 80px;">
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
    <div style="padding-left: 10px;padding-right: 10px;font-size: 9px;">
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
                            <td>Total</td>
                            <td><?php echo formatrp($data_product['grand_total']);?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td colspan="4">Discount</td>
                            <td><?php echo formatrp($discount_value);?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td colspan="4">Tax</td>
                            <td><?php echo formatrp($tax);?></td>
                        </tr>
                        <tr style="text-align: right">
                            <td colspan="4">Total Price</td>
                            <td><?php echo formatrp(((intval($data_product['grand_total']) - intval($discount_value)) + intval($tax))); ?></td>
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
                </table>
            </div>
        </div>
    </div>
<br>
<br>
    <div class="text-right">
        <p>Jakarta, <?php echo date('d-m-Y');?></p>
    </div>
    <div style="padding-left: 10px;padding-right: 10px;">
        <table>
            <tr>
                <td style="width: 500px;">
                    <table>
                        <tr>
                            <td>Diserahkan,</td>
                        </tr>
                        <tr>
                            <td style="height: 100px;">(...................................),</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Diterima ,</td>
                        </tr>
                        <tr>
                            <td style="height: 100px;">(...................................),</td>
                        </tr>
                    </table>
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