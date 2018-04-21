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
        <div style="text-align: center;font-size: 11px;">
            PT.WHOTO INDONESIA SEJAHTERA<br>
            Jl. Palem 8 Blok F No.1032 <br>
            Jakamulya, Bekasi Selatan 17146
        </div>
    </div>
    <div style="text-align: center;">
        <div style="font-size: 16x;font-weight: bolder;"><u>SURAT JALAN</u></div>
    </div>
<br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 12px;">
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
                            : <?php echo $customer['customer_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Alamat
                        </td>
                        <td>
                            : <?php echo $customer['customer_address']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telepon
                        </td>
                        <td>
                            : <?php echo $customer['customer_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            
                        </td>
                    </tr>
                </table>
            <td>
            <td style="width: 350px;">
                <table>
                    <tr>
                        <td style="width: 70px;">
                            No.DO
                        </td>
                        <td>
                            : <?php echo $data['do_code']; ?>
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
                    <!--<tr>
                        <td>
                            Tgl.Jatuh Temp
                        </td>
                        <td>
                            : <?php //echo ($due_date['pay_date'] == null ? '-' : tanggalan($due_date['pay_date'])); ?>
                        </td>
                    </tr>-->
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $total = 0;
                        foreach($list_product as $k=>$v) {
                            $total = $total+$v['qty']
                    ?>
                    <tr>
                        <td><?php echo $v['product_code'];?></td>
                        <td><?php echo $v['product_name'];?></td>
                        <td style="text-align:right;"><?php echo formatrp($v['qty']);?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right">Total</td>
                            <td class="text-right"><?php echo formatrp($total);?> Pcs</td>
                        </tr>
                    </tfoot>
                </table>    
            </div>
        </div>
    </div>
    <!--<div style="padding-left: 10px;padding-right: 10px;">
        <p style="font-size: 9px;font-weight: bolder;">Bonus :</p>
        <p style="font-size: 9px;"><?php echo $data['do_bonus'];?></p>
    </div>-->

    <br>
    <div class="text-right" style="padding-right: 10px;font-size: 12px;">
        <p><?php echo ucfirst(str_replace('cabang ','',strtolower($this->sessionGlobal['branch_name'])));?>, <?php echo tanggalan(date('Y-m-d'));?></p>
    </div>
    <br>
    <div style="padding-left: 10px;padding-right: 10px;font-size: 12px;">
        <table style="border:1px solid;width: 100%;">
            <tr>
                <td style="width: 30%;text-align: center;">
                    Tanda Terima
                </td>
                <td style="width: 30%;text-align: center;">
                    Pengirim
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