<?php echo form_open('discharges/update/' . $param2, array('id' => 'update_discharge_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$discharge_details = $this->security->xss_clean($this->db->get_where('discharge', array('discharge_id' => $param2))->result_array());
foreach ($discharge_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Accommodation *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="occupancy_id" data-parsley-required="true">
				<option value="">Select accommodation</option>
				<?php
				$occupancies = $this->security->xss_clean($this->db->get('occupancy')->result_array());
				foreach ($occupancies as $occupancy) :
					if ($this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->accommodation_type == 1)) :
				?>
						<optgroup label="<?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->name); ?>">
							<?php
							$beds = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $occupancy['accommodation_id'], 'accommodation_category_id' => $occupancy['accommodation_category_id']))->result_array());
							foreach ($beds as $bed) :
							?>
								<option <?php if ($occupancy['occupancy_id'] == $row['occupancy_id']) echo 'selected'; ?> value="<?php echo $occupancy['occupancy_id']; ?>">Bed <?php echo $bed['bed_number']; ?> of Room <?php echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed['accommodation_id']))->row()->room_number); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php elseif ($this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->accommodation_type) == 0) : ?>
						<optgroup label="<?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $occupancy['accommodation_category_id']))->row()->name); ?>">
							<?php
							$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $occupancy['accommodation_id'], 'accommodation_category_id' => $occupancy['accommodation_category_id']))->result_array());
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
		<label class="col-md-12 col-form-label">
			Select Medicine(s) *
			<span class="btn btn-sm btn-yellow pull-right mt-7" id="add-more">
				<i class="fa fa-plus"></i>
				<span>Add more</span>
			</span>
		</label>
		<div id="dynamic-field">
			<?php
			$discharge_details_info = $this->security->xss_clean($this->db->get_where('discharge_details', array('discharge_id' => $row['discharge_id']))->result_array());
			foreach ($discharge_details_info as $discharge_details_row) :
			?>
				<div id="row<?php echo $discharge_details_row['discharge_details_id']; ?>">
					<div class="form-inline m-b-15">
						<div class="col-md-11">
							<select style="width: 100%" class="form-control default-select2" name="medicine_ids[]" data-parsley-required="true">
								<option value="">Select Medicine</option>
								<?php
								$medicines = $this->security->xss_clean($this->db->get('medicine')->result_array());
								foreach ($medicines as $medicine) :
								?>
									<option <?php if ($medicine['medicine_id'] == $discharge_details_row['medicine_id']) echo 'selected'; ?> value="<?php echo $medicine['medicine_id']; ?>"><?php echo $medicine['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-1">
							<button type="button" name="remove" id="<?php echo $discharge_details_row['discharge_details_id']; ?>" class="btn btn-sm btn-danger btn_remove pull-right">X</button>
						</div>
					</div>
					<div class="form-inline m-b-15">
						<div class="col-md-6">
							<input value="<?php echo $discharge_details_row['dose']; ?>" name="doses[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Doses" />
						</div>
						<div class="col-md-6">
							<input value="<?php echo $discharge_details_row['medication_time']; ?>" name="medication_times[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Times" />
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Conditions *</label>
		<div class="col-md-12">
			<textarea name="conditions" data-parsley-required="true" class="form-control" placeholder="Type condition on discharge" rows="5"><?php echo html_escape($row['conditions']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Instructions</label>
		<div class="col-md-12">
			<textarea name="instructions" class="form-control" placeholder="Type discharge instructions" rows="5"><?php echo html_escape($row['instructions']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Next Appointment</label>
		<div class="col-md-12">
			<input value="<?php if ($row['next_appointment']) echo date('m/d/Y', $row['next_appointment']); ?>" name="next_appointment" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
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

	$('#update_discharge_details').parsley();
	FormPlugins.init();
</script>

<script type="text/javascript">
	$(document).ready(function() {
		"use strict";

		var i = 0;
		$('#add-more').on('click', function() {
			i++;
			$('#dynamic-field').append(`
			<div  id="row` + i + `">				
				<div class="form-inline m-b-15">
					<div class="col-md-11">
						<select style="width: 100%" class="form-control default-select2" name="medicine_ids[]" data-parsley-required="true">
							<option value="">Select Medicine</option>
							<?php
							$medicines = $this->security->xss_clean($this->db->get('medicine')->result_array());
							foreach ($medicines as $medicine) :
							?>
								<option value="<?php echo $medicine['medicine_id']; ?>"><?php echo $medicine['name']; ?></option>
							<?php endforeach; ?>
						</select>					
					</div>
					<div class="col-md-1">
						<button type="button" name="remove" id="` + i + `" class="btn btn-sm btn-danger btn_remove pull-right">X</button>
					</div>
				</div>
				<div class="form-inline m-b-15">
					<div class="col-md-6">
						<input name="doses[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Doses" />
					</div>
					<div class="col-md-6">
						<input name="medication_times[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Times" />
					</div>
				</div>
			</div>
			`);

			FormPlugins.init();
		});

		$(document).on('click', '.btn_remove', function() {
			var button_id = $(this).attr("id");
			$('#row' + button_id).remove();
		});
	});
</script>