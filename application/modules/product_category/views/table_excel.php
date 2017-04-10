<table border="1" cellpadding="2">
    <tr>
        <td align="center">Product Category Code</td>
        <td align="center">Product Category Name </td>
        <td align="center">Description</td>
        <td align="center">Status</td>
    </tr>
    <?php foreach($list as $kList=>$vList){ ?>
        <tr>
            <td><?php echo $vList['product_category_code'];?></td>
            <td><?php echo $vList['product_category_name'];?></td>
            <td><?php echo $vList['product_category_description'];?></td>
            <td><?php echo $vList['product_category_status'];?></td>
        </tr>
    <?php } ?>
</table>