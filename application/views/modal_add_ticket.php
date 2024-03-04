<?php echo form_open('tickets/create', array('id' => 'create_ticket', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php if ($this->session->userdata('user_type') != 'patient') : ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<?php endif; ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Subject *</label>
	<div class="col-md-12">
        <input name="subject" type="text" data-parsley-required="true" class="form-control" placeholder="Type subject of the ticket" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Details *</label>
	<div class="col-md-12">
        <textarea rows="10" style="resize: none" data-parsley-required="true" type="text" name="content" placeholder="Type details of the ticket" class="form-control"></textarea>
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
	
	$('#create_ticket').parsley();
	FormPlugins.init();
</script>