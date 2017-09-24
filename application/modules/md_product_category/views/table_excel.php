<table border="1" cellpadding="2">
        <tr style="font-weight: bolder;">
            <td align="center">Category</td>
			<td align="center">Status</td>
        </tr>
		<?php foreach($list as $kList=>$vList){ ?>
			<tr>
				<td><?php echo $vList['product_category'];?></td>
				<td><?php echo $vList['status'];?></td>
			</tr>
		<?php } ?>
    </table>