<?php echo form_open('transport_services/create', array('id' => 'create_transport_service', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="patient_id">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option value="<?php echo html_escape($patient['patient_id']); ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Transport *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="transport_id">
			<option value="">Select transport</option>
			<?php
			$transport_categories = $this->security->xss_clean($this->db->get('transport_category')->result_array());
			foreach ($transport_categories as $transport_category) :
			?>
				<optgroup label="<?php echo $transport_category['name']; ?>">
					<?php
					$transports =  $this->security->xss_clean($this->db->get_where('transport', array('transport_category_id' => $transport_category['transport_category_id']))->result_array());
					foreach ($transports as $transport) :
					?>
						<option value="<?php echo html_escape($transport['transport_id']); ?>"><?php echo $transport['transport_number']; ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
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
	
	$('#create_transport_service').parsley();
	FormPlugins.init();
</script>