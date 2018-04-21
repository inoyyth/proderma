<table border="1" cellpadding="2">
        <tr style="font-weight: bolder;">
            <td align="center">NIP</td>
			<td align="center">Name</td>
            <td align="center">Position</td>
            <td align="center">Branch</td>
            <td align="center">Email</td>
			<td align="center">Phone</td>
			<td align="center">Gender</td>
			<td align="center">Status</td>
        </tr>
		<?php foreach($list as $kList=>$vList){ ?>
			<tr>
				<td><?php echo $vList['employee_nip'];?></td>
				<td><?php echo $vList['employee_name'];?></td>
				<td><?php echo $vList['jabatan'];?></td>
				<td><?php echo $vList['branch_name'];?></td>
                <td><?php echo $vList['employee_email'];?></td>
				<td><?php echo $vList['employee_phone'];?></td>
                <td><?php echo $vList['gender'];?></td>
                <td><?php echo $vList['status'];?></td>
			</tr>
		<?php } ?>
    </table>