<table border="1" cellpadding="2">
    <tr>
        <td align="center">Product Brand Code</td>
        <td align="center">Product Brand Name </td>
        <td align="center">Description</td>
        <td align="center">Status</td>
    </tr>
    <?php foreach($list as $kList=>$vList){ ?>
        <tr>
            <td><?php echo $vList['product_brand_code'];?></td>
            <td><?php echo $vList['product_brand_name'];?></td>
            <td><?php echo $vList['product_brand_description'];?></td>
            <td><?php echo $vList['product_brand_status'];?></td>
        </tr>
    <?php } ?>
</table>