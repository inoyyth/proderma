<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Start Date</td>
		<td align="center">End Date</td>
		<td align="center">Customer</td>
		<td align="center">Assistant Name</td>
		<td align="center">Sales</td>
		<td align="center">Order ID</td>
		<td align="center">Activity</td>
		<td align="center">Related Code</td>
		<td align="center">Progress</td>
		<td align="center">Note</td>
		<td align="center">Longitude</td>
		<td align="center">Latitude</td>
		<td align="center">Branch</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['sales_visit_date'];?></td>
			<td><?php echo $vList['end_date'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
			<td><?php echo $vList['assistant_name'];?></td>
			<td><?php echo $vList['employee_name'];?></td>
			<td><?php echo $vList['order_id'];?></td>
			<td><?php echo $vList['objective'];?></td>
			<td><?php echo $vList['related_code'];?></td>
			<td><?php echo $vList['sales_visit_progress'];?></td>
			<td><?php echo $vList['sales_visit_note'];?></td>
			<td><?php echo $vList['longitude'];?></td>
			<td><?php echo $vList['latitude'];?></td>
			<td><?php echo $vList['branch_name'];?></td>
		</tr>
	<?php } ?>
</table>