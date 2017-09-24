<table border="1" cellpadding="2">
	<tr style="font-weight: bolder;">
		<td align="center">Customer Code</td>
		<td align="center">Customer Name</td>
		<td align="center">Group Product</td>
		<td align="center">Status</td>
		<td>&nbsp;</td>
	</tr>
	<?php foreach($list as $kList=>$vList){ ?>
		<tr>
			<td><?php echo $vList['customer_code'];?></td>
			<td><?php echo $vList['customer_name'];?></td>
			<td><?php echo $vList['group_customer_product'];?></td>
			<td><?php echo $vList['status_list_customer'];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr style="font-weight: bolder;">
			<td>&nbsp;</td>
			<td style="background-color: blue;" align="center">Product Code</td>
			<td style="background-color: blue;" align="center">Product Name</td>
			<td style="background-color: blue;" align="center">Product Category</td>
			<td style="background-color: blue;" align="center">Product Sub Category</td>
		</tr>
		<?php
			$this->db->select("m_product.*,m_product_category.product_category,m_product_sub_category.sub_category_name");
			$this->db->from('mapping_product');
			$this->db->join('m_product', 'm_product.id=mapping_product.id_product', 'left');
			$this->db->join('m_product_category', 'm_product_category.id=m_product.id_product_category', 'left');
			$this->db->join('m_product_sub_category', 'm_product_sub_category.id=m_product.id_product_sub_category', 'left');
			$this->db->where('mapping_product.id_customer', $vList['id']);
			$sql = $this->db->get()->result_array();
			
			foreach ($sql as $k=>$v) {
		?>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo $v['product_name'];?></td>
			<td><?php echo $v['product_code'];?></td>
			<td><?php echo $v['product_category'];?></td>
			<td><?php echo $v['sub_category_name'];?></td>
		</tr>
	<?php }} ?>
</table>