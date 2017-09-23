<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Code</td>
		<td align="center">Name</td>
		<td align="center">Clinic</td>
		<td align="center">Province</td>
		<td align="center">City</td>
		<td align="center">District</td>
		<td align="center">Longitude</td>
		<td align="center">Latitude</td>
		<td align="center">Address</td>
		<td align="center">Telephone</td>
		<td align="center">Email</td>
		<td align="center">Source Lead</td>
		<td align="center">Status Lead</td>
		<td align="center">Branch Office</td>
		<td align="center">Internal Notes</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['customer_code'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
			<td><?php echo $vList['customer_clinic'];?></td>
			<td><?php echo $vList['province_name'];?></td>
			<td><?php echo $vList['city_name'];?></td>
			<td><?php echo $vList['district_name'];?></td>
			<td><?php echo $vList['customer_longitude'];?></td>
			<td><?php echo $vList['customer_latitude'];?></td>
			<td><?php echo $vList['customer_address'];?></td>
			<td><?php echo $vList['customer_phone'];?></td>
			<td><?php echo $vList['customer_email'];?></td>
			<td><?php echo $vList['source_lead_customer'];?></td>
			<td><?php echo $vList['status_lead_customer'];?></td>
			<td><?php echo $vList['branch_name'];?></td>
			<td><?php echo $vList['customer_internal_notes'];?></td>
		</tr>
	<?php } ?>
</table>