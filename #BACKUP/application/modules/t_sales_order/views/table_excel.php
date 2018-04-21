<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">So Code</td>
		<td align="center">Customer Code</td>
		<td align="center">Customer Name</td>
		<td align="center">Sales NIP</td>
		<td align="center">Sales Name</td>
		<td align="center">So Date</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['so_code'];?></td>
			<td><?php echo $vList['customer_code'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
			<td><?php echo $vList['employee_nip'];?></td>
			<td><?php echo $vList['employee_name'];?></td>
			<td><?php echo $vList['so_date'];?></td>
	<?php } ?>
</table>