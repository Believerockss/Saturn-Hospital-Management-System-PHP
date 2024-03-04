<?php echo form_open('medicines/update/' . $param2, array('id' => 'update_medicine_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input value="<?php echo $this->security->xss_clean($this->db->get_where('medicine', array('medicine_id' => $param2))->row()->name); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the medicine" />
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
	
	$('#update_medicine_details').parsley();
	FormPlugins.init();
</script>