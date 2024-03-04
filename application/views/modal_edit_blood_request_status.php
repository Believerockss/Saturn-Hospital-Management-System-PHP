<?php echo form_open('blood_requests/update_status/' . $param2, array('id' => 'update_blood_request_status', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Requested Number of Bags *</label>
	<div class="col-md-12">
		<input readonly value="<?php echo $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param2))->row()->num_of_bags); ?>" type="text" class="form-control" />
	</div>
</div>
<?php
$blood_inventory_id    	=	$this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param2))->row()->blood_inventory_id);
$blood_group_inventory	=   $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $blood_inventory_id))->row()->num_of_bags);
?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Requested From *</label>
	<div class="col-md-12">
		<select disabled="true" style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="blood_donor_id">
			<option value="">Select blood donor</option>
			<?php
			$blood_donors = $this->security->xss_clean($this->db->get_where('blood_donor', array('status' => 0))->result_array());
			foreach ($blood_donors as $blood_donor) :
			?>
				<option <?php if ($blood_donor['blood_donor_id'] == $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param2))->row()->blood_donor_id)) echo 'selected'; ?> value="<?php echo html_escape($blood_donor['blood_donor_id']); ?>"><?php echo $blood_donor['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Status *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
			<option value="">Select status of the request</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param2))->row()->status) == 1) echo 'selected'; ?> value="1">Accepted</option>
			<option <?php if ($this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param2))->row()->status) == 2) echo 'selected'; ?> value="2">Rejected</option>
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
	
	$('#update_blood_request_status').parsley();
	FormPlugins.init();
</script>