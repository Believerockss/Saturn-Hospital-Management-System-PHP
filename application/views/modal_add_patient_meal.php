<?php echo form_open('patient_meals/create', array('id' => 'create_patient_meal', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
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
							<option value="<?php echo $occupancy['occupancy_id']; ?>">Bed <?php echo $bed['bed_number']; ?> of Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed['accommodation_id']))->row()->room_number); ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php elseif ($this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->accommodation_type) == 0) : ?>
					<optgroup label="<?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->name); ?>">
						<?php
						$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('status' => 1, 'accommodation_category_id' => $occupancy['accommodation_category_id']))->result_array());
						foreach ($accommodations as $accommodation) :
						?>
							<option value="<?php echo $occupancy['occupancy_id']; ?>">Room <?php echo $accommodation['room_number']; ?></option>
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
				<option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Breakfast</label>
	<div class="col-md-12">
		<input name="breakfast" type="text" class="form-control" placeholder="Type brekfast menu for the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Milk Break</label>
	<div class="col-md-12">
		<input name="milk_break" type="text" class="form-control" placeholder="Type milk break menu for the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Lunch</label>
	<div class="col-md-12">
		<input name="lunch" type="text" class="form-control" placeholder="Type lunch menu for the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Tea Break</label>
	<div class="col-md-12">
		<input name="tea_break" type="text" class="form-control" placeholder="Type tea break menu for the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Dinner</label>
	<div class="col-md-12">
		<input name="dinner" type="text" class="form-control" placeholder="Type dinner menu for the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Extra Note</label>
	<div class="col-md-12">
		<textarea name="extra_note" class="form-control" placeholder="Type discharge instructions" rows="5"></textarea>
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
	
	$('#create_patient_meal').parsley();
	FormPlugins.init();
</script>