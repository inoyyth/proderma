<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Promo Code</td>
		<td align="center">Promo Name</td>
		<td align="center">Promo Description</td>
		<td align="center">Promo File</td>
		<td align="center">Status</td>
	</tr>
	<?php 
		foreach($list as $kList=>$vList){ 
			$file = explode('/',$vList['promo_file']);
	?>
		<tr>
			<td><?php echo $vList['promo_code'];?></td>
			<td><?php echo $vList['promo_name'];?></td>
			<td><?php echo $vList['promo_description'];?></td>
			<td><?php echo base_url().'print-promo-'.end($file);?></td>
			<td><?php echo $vList['status'];?></td>
		</tr>
	<?php } ?>
</table>