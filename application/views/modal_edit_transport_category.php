<?php echo form_open('transport_categories/update/' . $param2, array('id' => 'update_transport_category', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$transport_categories = $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $param2))->result_array());
foreach ($transport_categories as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the transport category" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['cost']); ?>" name="cost" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type service cost of the transport category" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Description *</label>
		<div class="col-md-12">
			<textarea maxlength="255" name="description" data-parsley-required="true" class="form-control" placeholder="Type description of the transport category" rows="5"><?php echo html_escape($row['description']); ?></textarea>
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
	
	$('#update_transport_category').parsley();
	FormPlugins.init();
</script>