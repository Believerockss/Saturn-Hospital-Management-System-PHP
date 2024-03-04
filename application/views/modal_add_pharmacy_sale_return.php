<?php echo form_open('pharmacy_sale_returns/create/' . $param2, array('name' => 'create_pharmacy_sale_return', 'id' => 'create_pharmacy_sale_return', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Product Code</th>
				<th>Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
				<th>Sold Quantity</th>
				<th>Return</th>
				<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$pharmacy_sales = $this->security->xss_clean($this->db->get_where('pharmacy_sale_details', array('pharmacy_sale_id' => $param2))->result_array());
			foreach ($pharmacy_sales as $pharmacy_sale) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>
						<?php 
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->name); 
							else 
								echo 'Product Name not found.';
						?>
					</td>
					<td>
						<?php
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->num_rows() > 0) 
								echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->code); 
							else 
								echo 'Product code not found.';
						?>
					</td>
					<td>
						<?php 
							if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->num_rows() > 0) {
								$unit_price = $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->price);
								echo $unit_price = $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->price); 
							} else {
								$unit_price = 0;
								echo $unit_price = 'Unit price not found.';
							}
						?>
					</td>
					<td id="sold_quantity<?php echo $count; ?>">
						<?php
						$returned_quantity = 0;
						$num_of_row = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $param2))->num_rows());
						if ($num_of_row > 0) {
							$sale_returns = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $param2))->result_array());
							foreach ($sale_returns as $sale_return) {
								$sale_return_details = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return_details', array('pharmacy_sale_return_id' => $sale_return['pharmacy_sale_return_id']))->result_array());
								foreach ($sale_return_details as $sale_return_detail) {
									if ($sale_return_detail['pharmacy_inventory_id'] == $pharmacy_sale['pharmacy_inventory_id']) {
										$returned_quantity += $sale_return_detail['quantity'];
									}
								}
							}
							echo $pharmacy_sale['quantity'] - $returned_quantity;
						} else {
							echo $pharmacy_sale['quantity'];
						}
						?>
					</td>
					<td>
						<input value="<?php echo $pharmacy_sale['pharmacy_inventory_id']; ?>" name="returned_pharmacy_inventory_ids[]" type="text" class="form-control hide-n-seek" placeholder="Type quantity" />
						<input id="returned_quantity<?php echo $count; ?>" name="returned_quantities[]" type="text" class="form-control" placeholder="Type quantity" />
					</td>
					<td><?php echo $unit_price * ($pharmacy_sale['quantity'] - $returned_quantity); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="alert alert-warning hide-n-seek" id="show_error"></div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Submit</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";

	$('#create_pharmacy_sale_return').parsley();
	FormPlugins.init();

	$('.modal-dialog').css('max-width', '720px');

	$('#create_pharmacy_sale_return').on('submit', function() {
		var count = "<?php echo $count; ?>";
		var null_count = 0;

		for (var i = 2; i <= count; i++) {
			var sold_quantity = parseInt($('#sold_quantity' + i).html());
			var returned_quantity = $('#returned_quantity' + i).val();

			if (returned_quantity == '') null_count++;

			if (returned_quantity > sold_quantity) {
				$('#show_error').show();
				$('#show_error').text('Prduct return quantity can not be greater than sold product quantity');

				return false;
			} else if (null_count == (count - 1)) {
				$('#show_error').show();
				$('#show_error').text('Do not submit If you do not fill any of the input field');

				return false;
			} else if (returned_quantity < 0) {
				$('#show_error').show();
				$('#show_error').text('Prduct return quantity can not be less than zero');

				return false;
			}
		}
	});
</script>