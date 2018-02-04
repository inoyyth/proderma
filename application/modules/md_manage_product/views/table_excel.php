<table border="1" cellpadding="2">
        <tr style="font-weight: bolder;">
            <td align="center">Product Code</td>
			<td align="center">Product Name</td>
            <td align="center">Product Category</td>
            <td align="center">Product Price</td>
            <td align="center">Product Group</td>
			<td align="center">Product Klasifikasi</td>
			<td align="center">Product Komposisi</td>
			<td align="center">Product Sediaan</td>
			<td align="center">Product Status</td>
        </tr>
		<?php foreach($list as $kList=>$vList){ ?>
			<tr>
				<td><?php echo $vList['product_code'];?></td>
				<td><?php echo $vList['product_name'];?></td>
                <td><?php echo $vList['product_category'];?></td>
                <td><?php echo $vList['product_price'];?></td>
                <td><?php echo $vList['group_product'];?></td>
				<td><?php echo $vList['klasifikasi'];?></td>
				<td><?php echo $vList['komposisi'];?></td>
				<td><?php echo $vList['sediaan'];?></td>
				<td><?php echo $vList['status'];?></td>
			</tr>
		<?php } ?>
    </table>