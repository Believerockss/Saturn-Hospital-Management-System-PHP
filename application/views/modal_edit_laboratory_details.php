<?php echo form_open('laboratories/update/' . $param2, array('id' => 'update_laboratory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('laboratory', array('laboratory_id' => $param2))->row()->name)); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the laboratory" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Room Number *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('laboratory', array('laboratory_id' => $param2))->row()->room_number)); ?>" name="room_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type number of the room" />
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
	
	$('#update_laboratory').parsley();
	FormPlugins.init();
</script>