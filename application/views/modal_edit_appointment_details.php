<?php echo form_open('appointments/update/' . $param2, array('id' => 'update_appointment_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$appointment_details = $this->security->xss_clean($this->db->get_where('appointment', array('appointment_id' => $param2))->result_array());
foreach ($appointment_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Doctor *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="doctor_id">
				<option value="">Select doctor of reference</option>
				<?php
				$doctor_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('is_doctor' => 1))->result_array());
				foreach ($doctor_categories as $doctor_category) :
				?>
					<optgroup label="<?php echo $doctor_category['name']; ?>">
						<?php
						$doctors = $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $doctor_category['staff_category_id']))->result_array());
						foreach ($doctors as $doctor) :
						?>
							<option <?php if ($doctor['doctor_id'] == $row['doctor_id']) echo 'selected'; ?> value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Patient *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
				<option value="">Select patient</option>
				<?php
				$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
				foreach ($patients as $patient) :
				?>
					<option <?php if ($patient['patient_id'] == $row['patient_id']) echo 'selected'; ?> value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Appointment Date *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['appointment_date'])); ?>" name="appointment_date" id="masked-input-date" type="text" data-parsley-required="true" class="form-control" placeholder="mm/dd/yyyy" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Appointment Time *</label>
		<div class="col-md-12">
			<div class="input-group bootstrap-timepicker">
				<input value="<?php echo html_escape($row['appointment_time']); ?>" data-parsley-required="true" name="appointment_time" id="timepicker" type="text" class="form-control custom_timepicker" />
				<span class="input-group-addon"><i class="fa fa-clock"></i></span>
			</div>
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
	
	$('#update_appointment_details').parsley();
	FormPlugins.init();
</script>