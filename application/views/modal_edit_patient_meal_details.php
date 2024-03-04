<?php echo form_open('patient_meals/update/' . $param2, array('id' => 'update_patient_meal_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$patient_meals = $this->security->xss_clean($this->db->get_where('patient_meal', array('patient_meal_id' => $param2))->result_array());
foreach ($patient_meals as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Accommodation *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="occupancy_id" data-parsley-required="true">
				<option value="">Select accommodation</option>
				<?php
				$occupancies = $this->security->xss_clean($this->db->get_where('occupancy', array('status' => 1))->result_array());
				foreach ($occupancies as $occupancy) :
					if ($this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->accommodation_type) == 1) :
				?>
						<optgroup label="<?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->name); ?>">
							<?php
							$beds = $this->security->xss_clean($this->db->get_where('bed', array('status' => 1, 'accommodation_category_id' => $occupancy['accommodation_category_id']))->result_array());
							foreach ($beds as $bed) :
							?>
								<option <?php if ($occupancy['occupancy_id'] == $row['occupancy_id']) echo 'selected'; ?> value="<?php echo $occupancy['occupancy_id']; ?>">Bed <?php echo $bed['bed_number']; ?> of Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed['accommodation_id']))->row()->room_number); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php elseif ($this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->accommodation_type) == 0) : ?>
						<optgroup label="<?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->name); ?>">
							<?php
							$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('status' => 1, 'accommodation_category_id' => $occupancy['accommodation_category_id']))->result_array());
							foreach ($accommodations as $accommodation) :
							?>
								<option <?php if ($occupancy['occupancy_id'] == $row['occupancy_id']) echo 'selected'; ?> value="<?php echo $occupancy['occupancy_id']; ?>">Room <?php echo $accommodation['room_number']; ?></option>
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
			<select style="width: 100%" class="form-control default-select2" name="doctor_id" data-parsley-required="true">
				<option value="">Select doctor</option>
				<?php
				$doctors = $this->security->xss_clean($this->db->get('doctor')->result_array());
				foreach ($doctors as $doctor) :
				?>
					<option <?php if ($doctor['doctor_id'] == $row['doctor_id']) echo 'selected'; ?> value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Breakfast</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['breakfast']); ?>" name="breakfast" type="text" class="form-control" placeholder="Type brekfast menu for the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Milk Break</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['milk_break']); ?>" name="milk_break" type="text" class="form-control" placeholder="Type milk break menu for the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Lunch</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['lunch']); ?>" name="lunch" type="text" class="form-control" placeholder="Type lunch menu for the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Tea Break</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['tea_break']); ?>" name="tea_break" type="text" class="form-control" placeholder="Type tea break menu for the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Dinner</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['dinner']); ?>" name="dinner" type="text" class="form-control" placeholder="Type dinner menu for the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Extra Note</label>
		<div class="col-md-12">
			<textarea name="extra_note" class="form-control" placeholder="Type discharge instructions" rows="5"><?php echo html_escape($row['extra_note']); ?></textarea>
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
	
	$('#update_patient_meal_details').parsley();
	FormPlugins.init();
</script>