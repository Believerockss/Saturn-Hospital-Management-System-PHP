<?php echo form_open('cafeteria_inventory/create', array('id' => 'create_cafeteria_inventory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the inventory" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Product Code *</label>
	<div class="col-md-12">
		<input name="code" type="text" data-parsley-required="true" class="form-control" placeholder="Type code of the inventory" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Unit *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="unit_id">
			<option value="">Select unit</option>
			<?php
			$units = $this->security->xss_clean($this->db->get_where('unit', array('unit_for' => 2))->result_array());
			foreach ($units as $unit) :
			?>
				<option value="<?php echo html_escape($unit['unit_id']); ?>"><?php echo $unit['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input name="price" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type unit price of the inventory" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Quantity *</label>
	<div class="col-md-12">
		<input name="quantity" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type quantity of an unit" />
	</div>
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
	
	$('#create_cafeteria_inventory').parsley();
	FormPlugins.init();
</script>