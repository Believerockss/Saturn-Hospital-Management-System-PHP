<?php echo form_open('blood_inventory/update', array('id' => 'edit_blood_inventory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$blood_inventory = $this->security->xss_clean($this->db->get('blood_inventory')->result_array());
foreach ($blood_inventory as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Number of Bags (<?php echo $row['blood_group_name']; ?>) *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['num_of_bags']); ?>" name="num_of_bags[]" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type number of bags" />
		</div>
	</div>
<?php endforeach; ?>

<div class="form-group">
	<label class="col-md-12 control-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Update</button>
	</div>
</div>
<?php echo form_close(); ?>


<script>
	"use strict";
	
	$('#edit_blood_inventory').parsley();
</script>