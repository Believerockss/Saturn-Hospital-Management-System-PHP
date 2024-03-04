<?php echo form_open('pharmacy_inventory/update_inventory/' . $param2, array('id' => 'update_pharmacy_inventory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input readonly value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $param2))->row()->name)); ?>" type="text" data-parsley-required="true" class="form-control" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Current Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input readonly value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $param2))->row()->quantity)); ?>" type="quantity" data-parsley-required="true" class="form-control" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Operation *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="operation">
			<option value="">Select operation</option>
			<option value="add">Add</option>
			<option value="subtract">Subtract</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Quantity *</label>
	<div class="col-md-12">
		<input name="quantity" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type quantity to add or subtract to the inventory" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Update</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_pharmacy_inventory').parsley();
	FormPlugins.init();
</script>