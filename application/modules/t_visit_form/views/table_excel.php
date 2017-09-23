<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Code</td>
		<td align="center">Subject</td>
		<td align="center">Attendence</td>
		<td align="center">Supervisor</td>
		<td align="center">Activity</td>
		<td align="center">Start Date</td>
		<td align="center">End Date</td>
		<td align="center">Location</td>
		<td align="center">Description</td>
		<td align="center">Progress</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['visit_form_code'];?></td>
			<td><?php echo $vList['visit_form_subject'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
			<td><?php echo $vList['employee_name'];?></td>
			<td><?php echo $vList['activity_name'];?></td>
			<td><?php echo $vList['visit_form_start_date'];?></td>
			<td><?php echo $vList['visit_form_end_date'];?></td>
			<td><?php echo $vList['visit_form_location'];?></td>
			<td><?php echo $vList['visit_form_description'];?></td>
			<td><?php echo $vList['visit_form_progress'];?></td>
		</tr>
	<?php } ?>
</table>