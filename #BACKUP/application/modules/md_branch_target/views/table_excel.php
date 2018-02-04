<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Jabatan</td>
		<td align="center">Status</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['jabatan'];?></td>
			<td><?php echo $vList['status'];?></td>
		</tr>
	<?php } ?>
</table>