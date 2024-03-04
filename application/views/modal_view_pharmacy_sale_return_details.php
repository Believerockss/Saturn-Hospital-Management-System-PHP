<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Product Code</th>
				<th>Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
				<th>Returned Quantity</th>
				<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$sale_return_details	=	$this->security->xss_clean($this->db->get_where('pharmacy_sale_return_details', array('pharmacy_sale_return_id' => $param2))->result_array());
			foreach ($sale_return_details as $sale_return_detail) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>
						<?php 
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->name); 
							else
								echo 'Product name not found.';
						?>
					</td>
					<td>
						<?php 
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->code); 
							else
								echo 'Product code not found.';
						?>
					</td>
					<td>
						<?php 
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->num_rows() > 0) 
								echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->price); 
							else
								echo 'Unit price not found.';
						?>
					</td>
					<td><?php echo $return_unit_price = $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->price); ?></td>
					<td><?php echo $sale_return_detail['quantity']; ?></td>
					<td><?php echo $return_unit_price * $sale_return_detail['quantity']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>