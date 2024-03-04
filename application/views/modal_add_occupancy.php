<?php echo form_open('occupancies/create', array('id' => 'create_occupancy', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
			<option value="">Select patient to admit</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get_where('patient', array('status' => 0))->result_array());
			foreach ($patients as $patient) :
			?>
				<option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name'] . ' - ' . $patient['pid']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Accommodation *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="accommodation_and_category_id" data-parsley-required="true">
			<option value="">Select accommodation</option>
			<?php
			$accommodation_categories = $this->security->xss_clean($this->db->get('accommodation_category')->result_array());
			foreach ($accommodation_categories as $accommodation_category) :
				if ($accommodation_category['accommodation_type'] == 2) :
			?>
					<optgroup label="<?php echo $accommodation_category['name']; ?>">
						<?php
						$beds = $this->security->xss_clean($this->db->get_where('bed', array('status' => 0, 'root_accommodation_category_id' => $accommodation_category['accommodation_category_id']))->result_array());
						foreach ($beds as $bed) :
						?>
							<option value="<?php echo $bed['bed_id'] . ' ' . $bed['accommodation_category_id']; ?>">Bed <?php echo $bed['bed_number']; ?> of Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed['accommodation_id']))->row()->room_number); ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php elseif ($accommodation_category['accommodation_type'] == 0) : ?>
					<optgroup label="<?php echo $accommodation_category['name']; ?>">
						<?php
						$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('status' => 0, 'accommodation_category_id' => $accommodation_category['accommodation_category_id']))->result_array());
						foreach ($accommodations as $accommodation) :
						?>
							<option value="<?php echo $accommodation['accommodation_id'] . ' ' . $accommodation['accommodation_category_id']; ?>">Room <?php echo $accommodation['room_number']; ?></option>
						<?php endforeach; ?>
					</optgroup>
			<?php
				endif;
			endforeach;
			?>
		</select>
	</div>
</div>
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
						<option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Reason *</label>
	<div class="col-md-12">
		<textarea name="reason" class="form-control" data-parsley-required="true" placeholder="Type reasons for admission" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Extra Note *</label>
	<div class="col-md-12">
		<textarea name="extra_note" class="form-control" data-parsley-required="true" placeholder="Type extra notes on the admission" rows="5"></textarea>
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
	
	$('#create_occupancy').parsley();
	FormPlugins.init();
</script>