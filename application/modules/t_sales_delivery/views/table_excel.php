<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Delivery Code</td>
		<td align="center">SO Code</td>
		<td align="center">Delivery Date</td>
		<td align="center">Customer Code</td>
		<td align="center">Customer Name</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['do_code'];?></td>
			<td><?php echo $vList['so_code'];?></td>
			<td><?php echo $vList['do_date'];?></td>
			<td><?php echo $vList['customer_code'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
		</tr>
	<?php } ?>
</table>