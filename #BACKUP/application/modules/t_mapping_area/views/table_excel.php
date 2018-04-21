<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">NIP</td>
		<td align="center">Name</td>
		<td align="center">Position</td>
		<td align="center">Branch</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['employee_nip'];?></td>
			<td><?php echo $vList['employee_name'];?></td>
			<td><?php echo $vList['jabatan'];?></td>
			<td><?php echo $vList['branch_name'];?></td>
		</tr>
		<tr style="font-weight: bolder;">
			<td>&nbsp;</td>
			<td style="background-color: blue;" align="center">Area</td>
			<td style="background-color: blue;" align="center">Customer Code</td>
			<td style="background-color: blue;" align="center">Customer Name</td>
		</tr>
		<?php
			$this->db->select('sales_mapping_area.*,m_subarea.subarea_name,m_customer.customer_code,customer_name');
			$this->db->from('sales_mapping_area');
			$this->db->join('m_subarea', 'm_subarea.id=sales_mapping_area.id_sub_area', 'left');
			$this->db->join('m_customer', 'm_customer.id=sales_mapping_area.id_customer', 'left');
			$this->db->where('sales_mapping_area.id_sales', $vList['id']);
			$sql = $this->db->get()->result_array();
			
			foreach ($sql as $k=>$v) {
		?>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo $v['subarea_name'];?></td>
			<td><?php echo $v['customer_code'];?></td>
			<td><?php echo $v['customer_name'];?></td>
		</tr>
	<?php }} ?>
</table>