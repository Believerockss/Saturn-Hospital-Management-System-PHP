<?php echo form_open('blood_inventory/update_group/' . $param2, array('id' => 'blood_group_inventory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Number of Bags (<?php echo $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $param2))->row()->blood_group_name); ?>) *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $param2))->row()->num_of_bags)); ?>" name="num_of_bags" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type number of bags" />
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
	
	$('#blood_group_inventory').parsley();
</script>