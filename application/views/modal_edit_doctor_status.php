<?php echo form_open('staff/update_status/' . $param2 . '/' . $param3, array('id' => 'update_doctor_status', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Status *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
			<option value="">Select status of the doctor</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $param3))->row()->status) == 1) echo 'selected'; ?> value="1">Active</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $param3))->row()->status) == 0) echo 'selected'; ?> value="0">Inactive</option>
		</select>
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
	
	$('#update_doctor_status').parsley();
	FormPlugins.init();
</script>