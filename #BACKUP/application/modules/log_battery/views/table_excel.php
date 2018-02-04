<table border="1" cellpadding="2">
    <tr>
        <td align="center">SO.Code</td>
        <td align="center">Cust.Code</td>
        <td align="center">Cust.Name</td>
        <td align="center">Sales NIP</td>
        <td align="center">Sales</td>
        <td align="center">SO.Date</td>
        <td align="center">Discount</td>
        <td align="center">Total</td>
    </tr>
    <?php foreach ($list as $kList => $vList) { ?>
        <tr>
            <td><?php echo $vList['so_code']; ?></td>
            <td><?php echo $vList['customer_code']; ?></td>
            <td><?php echo $vList['customer_name']; ?></td>
            <td><?php echo $vList['employee_nip']; ?></td>
            <td><?php echo $vList['employee_name']; ?></td>
            <td><?php echo $vList['so_date']; ?></td>
            <td><?php echo $vList['so_discount_value'] . ($vList['so_discount_type'] == 2 ? "%" : ""); ?></td>
            <td><?php echo floatval($vList['so_grand_total']) - floatval($vList['so_tax_amount']); ?></td>
        </tr>
    <?php } ?>
</table>