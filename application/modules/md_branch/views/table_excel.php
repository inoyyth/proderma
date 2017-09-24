<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Branch Code</td>
		<td align="center">Branch Name</td>
		<td align="center">Branch Address</td>
		<td align="center">Branch Email</td>
		<td align="center">Branch Phone</td>
		<td align="center">Status</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['branch_code'];?></td>
			<td><?php echo $vList['branch_name'];?></td>
			<td><?php echo $vList['branch_address'];?></td>
			<td><?php echo $vList['branch_email'];?></td>
			<td><?php echo $vList['branch_telp'];?></td>
			<td><?php echo $vList['status'];?></td>
		</tr>
	<?php } ?>
</table>