<?php echo form_open('occupancies/update/' . $param2, array('id' => 'update_occupancy', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$occupancy_details = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param2))->result_array());
foreach ($occupancy_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Patient *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
				<option value="">Select patient to admit</option>
				<option value="<?php echo $row['patient_id']; ?>" selected><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name) . ' - ' . $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->pid); ?></option>
				<?php
				$patients = $this->security->xss_clean($this->db->get_where('patient', array('status' => 0))->result_array());
				foreach ($patients as $patient) :
				?>
					<option <?php if ($patient['patient_id'] == $row['patient_id']) echo 'selected'; ?> value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name'] . ' - ' . $patient['pid']; ?></option>
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
				$accommodation_type = $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $row['accommodation_category_id']))->row()->accommodation_type);

				$accommodation_categories = $this->security->xss_clean($this->db->get('accommodation_category')->result_array());
				foreach ($accommodation_categories as $accommodation_category) :
					if ($accommodation_category['accommodation_type'] == 2) :
				?>
						<optgroup label="<?php echo $accommodation_category['name']; ?>">
							<?php
							$root_accommodation_category_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $row['accommodation_id']))->row()->root_accommodation_category_id);
							if ($accommodation_type == 1 && $accommodation_category['accommodation_category_id'] == $root_accommodation_category_id) :
								$bed_number = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $row['accommodation_id']))->row()->bed_number);
								$bed_accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $row['accommodation_id']))->row()->accommodation_id);
								$room_number = $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->row()->room_number);
							?>
								<option value="<?php echo $row['accommodation_id'] . ' ' . $row['accommodation_category_id']; ?>" selected>Bed <?php echo $bed_number; ?> of Room <?php echo $room_number; ?></option>
							<?php endif; ?>
							<?php
							$beds = $this->security->xss_clean($this->db->get_where('bed', array('status' => 0, 'root_accommodation_category_id' => $accommodation_category['accommodation_category_id']))->result_array());
							foreach ($beds as $bed) :
							?>
								<option value="<?php echo $bed['bed_id'] . ' ' . $bed['accommodation_category_id']; ?>">Bed <?php echo $bed['bed_number']; ?> of Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed['accommodation_id']))->row()->room_number); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php elseif ($accommodation_category['accommodation_type'] == 0) : ?>
						<optgroup label="<?php echo $accommodation_category['name']; ?>">
							<?php if ($accommodation_type != 1 && $accommodation_category['accommodation_category_id'] == $row['accommodation_category_id']) : ?>
								<option value="<?php echo $row['accommodation_id'] . ' ' . $row['accommodation_category_id']; ?>" selected>Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $row['accommodation_id']))->row()->room_number); ?></option>
							<?php endif; ?>
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
							<option <?php if ($doctor['doctor_id'] == $row['doctor_id']) echo 'selected'; ?> value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Reason *</label>
		<div class="col-md-12">
			<textarea name="reason" class="form-control" data-parsley-required="true" placeholder="Type reasons for admission" rows="5"><?php echo html_escape($row['reason']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Extra Note *</label>
		<div class="col-md-12">
			<textarea name="extra_note" class="form-control" data-parsley-required="true" placeholder="Type extra notes on the admission" rows="5"><?php echo html_escape($row['extra_note']); ?></textarea>
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
	
	$('#update_occupancy').parsley();
	FormPlugins.init();
</script>