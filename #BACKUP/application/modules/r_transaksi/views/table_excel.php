<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">SO/Code</td>
		<td align="center">SO.Date</td>
		<td align="center">DO.Status</td>
		<td align="center">Invoice Status</td>
		<td align="center">Due Date Status</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['so_code'];?></td>
			<td><?php echo $vList['so_date'];?></td>
			<td><?php echo $vList['do_status'];?></td>
			<td><?php echo $vList['invoice_status'];?></td>
			<td><?php echo $vList['due_date'];?></td>
		</tr>
	<?php } ?>
</table>