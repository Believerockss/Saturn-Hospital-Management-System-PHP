<?php echo form_open('departments/update/' . $param2, array('id' => 'update_department', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('department', array('department_id' => $param2))->row()->name)); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the department" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description</label>
	<div class="col-md-12">
		<textarea name="description" class="form-control" placeholder="Type description of the department" rows="5"><?php echo html_escape($this->security->xss_clean($this->db->get_where('department', array('department_id' => $param2))->row()->description)); ?></textarea>
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
	
	$('#update_department').parsley();
	FormPlugins.init();
</script>