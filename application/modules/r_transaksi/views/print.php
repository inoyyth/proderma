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
<div id="printThis">
    <div style="width: 200px;padding-left: 10px;padding-top: 2px;">
        <img style="width: 190px;" src="<?php echo base_url('assets/images/logo.png'); ?>">
        <br>
        <div style="text-align: center;font-size: 10px;">
            PT.WHOTO INDONESIA SEJAHTERA<br>
            Jl. Palem 8 Blok F No.1032 <br>
            Jakamulya Bekasi 17146
        </div>
    </div>
    <div style="text-align: center;">
        <div style="font-size: 16x;font-weight: bolder;"><u>PURCHASE ORDER</u></div>
    </div>
<br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 10px;">
        <table>
            <td style="width: 450px;">
                <table>
                    <tr>
                        <td style="width: 70px;">
                            TANGGAL
                        </td>
                        <td>
                            : <?php echo tanggalan($data['so_date']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NAMA ME
                        </td>
                        <td>
                            : <?php echo $data['employee_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            AREA
                        </td>
                        <td>
                            : <?php echo $data['area_name'] . '/' . $data['subarea_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            
                        </td>
                    </tr>
                </table>
            <td>
            <td style="width: 450px;">
                <table>
                    <tr>
                        <td style="width: 70px;">
                            No. DO
                        </td>
                        <td>
                            : <?php echo $data['so_code']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CUSTOMER
                        </td>
                        <td>
                            : <?php echo $data['customer_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            TELP
                        </td>
                        <td>
                            : <?php echo $data['customer_phone']; ?>
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
                        <th>Total</th>
                        <th>Keterangan</th>
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
                        <td><?php echo $v['description'];?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="text-right" style="padding-right: 10px;font-size: 10px;">
        <p>Jakarta, <?php echo tanggalan(date('Y-m-d'));?></p>
    </div>
    <br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 10px;">
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
                        <td style="text-align: center;">CHECK1</td>
                        <td style="text-align: center;">CHECK2</td>
                    </table>
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