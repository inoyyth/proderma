<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Area</td>
		<td align="center">Subarea Code</td>
		<td align="center">Subarea Name</td>
		<td align="center">Subarea Description</td>
		<td align="center">Status</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['area_name'];?></td>
			<td><?php echo $vList['subarea_code'];?></td>
			<td><?php echo $vList['subarea_name'];?></td>
			<td><?php echo $vList['subarea_description'];?></td>
			<td><?php echo $vList['status'];?></td>
		</tr>
	<?php } ?>
</table>