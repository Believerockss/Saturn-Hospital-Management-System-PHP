<?php echo form_open('pharmacy_inventory/update/' . $param2, array('id' => 'update_pharmacy_inventory_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$pharmacy_inventory = $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $param2))->result_array());
foreach ($pharmacy_inventory as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the inventory" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Product Code *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['code']); ?>" name="code" type="text" data-parsley-required="true" class="form-control" placeholder="Type code of the inventory" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Unit *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="unit_id">
				<option value="">Select unit</option>
				<?php
				$units = $this->security->xss_clean($this->db->get_where('unit', array('unit_for' => 1))->result_array());
				foreach ($units as $unit) :
				?>
					<option <?php if ($row['unit_id'] == $unit['unit_id']) echo 'selected'; ?> value="<?php echo html_escape($unit['unit_id']); ?>"><?php echo $unit['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['price']); ?>" name="price" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type unit price of the inventory" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-12 col-form-label"></label>
		<div class="col-md-12">
			<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
			<button type="submit" class="btn btn-yellow pull-right">Update</button>
		</div>
	</div>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_pharmacy_inventory_details').parsley();
	FormPlugins.init();
</script>