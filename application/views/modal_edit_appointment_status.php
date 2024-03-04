<?php echo form_open('appointments/update_status/' . $param2, array('id' => 'update_appointment_status', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Status *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
			<option value="">Select status of the donor</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('appointment', array('appointment_id' => $param2))->row()->status) == 0) echo 'selected'; ?> value="0">Pending</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('appointment', array('appointment_id' => $param2))->row()->status) == 1) echo 'selected'; ?> value="1">Done</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('appointment', array('appointment_id' => $param2))->row()->status) == 2) echo 'selected'; ?> value="2">Cancelled</option>
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
	
	$('#update_appointment_status').parsley();
	FormPlugins.init();
</script>