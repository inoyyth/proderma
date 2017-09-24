<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Invoice Code</td>
		<td align="center">No Faktur</td>
		<td align="center">DO.Code</td>
		<td align="center">SO.Code</td>
		<td align="center">Status</td>
		<td align="center">DueDate</td>
		<td align="center">Description</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['invoice_code'];?></td>
			<td><?php echo $vList['no_faktur'];?></td>
			<td><?php echo $vList['do_code'];?></td>
			<td><?php echo $vList['so_code'];?></td>
			<td><?php echo $vList['pay_duedate_status'];?></td>
			<td><?php echo $vList['due_date'];?></td>
			<td><?php echo $vList['pay_duedate_description'];?></td>
		</tr>
	<?php } ?>
</table>