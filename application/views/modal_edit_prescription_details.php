<?php echo form_open('prescriptions/update/' . $param2, array('id' => 'update_prescription_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$prescription_details = $this->security->xss_clean($this->db->get_where('prescription', array('prescription_id' => $param2))->result_array());
foreach ($prescription_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Patient *</label>
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
		<label class="col-md-12 col-form-label">Disease *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="disease_id" data-parsley-required="true">
				<option value="">Select disease</option>
				<?php
				$diseases = $this->security->xss_clean($this->db->get('disease')->result_array());
				foreach ($diseases as $disease) :
				?>
					<option <?php if ($disease['disease_id'] == $row['disease_id']) echo 'selected'; ?> value="<?php echo $disease['disease_id']; ?>"><?php echo $disease['name']; ?></option>
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
			$prescription_details_info = $this->security->xss_clean($this->db->get_where('prescription_details', array('prescription_id' => $row['prescription_id']))->result_array());
			foreach ($prescription_details_info as $prescription_details_row) :
			?>
				<div id="row<?php echo $prescription_details_row['prescription_details_id']; ?>">
					<div class="form-inline m-b-15">
						<div class="col-md-11">
							<select style="width: 100%" class="form-control default-select2" name="medicine_ids[]" data-parsley-required="true">
								<option value="">Select Medicine</option>
								<?php
								$medicines = $this->security->xss_clean($this->db->get('medicine')->result_array());
								foreach ($medicines as $medicine) :
								?>
									<option <?php if ($medicine['medicine_id'] == $prescription_details_row['medicine_id']) echo 'selected'; ?> value="<?php echo $medicine['medicine_id']; ?>"><?php echo $medicine['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-1">
							<button type="button" name="remove" id="<?php echo $prescription_details_row['prescription_details_id']; ?>" class="btn btn-sm btn-danger btn_remove pull-right">X</button>
						</div>
					</div>
					<div class="form-inline m-b-15">
						<div class="col-md-6">
							<input value="<?php echo $prescription_details_row['dose']; ?>" name="doses[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Doses" />
						</div>
						<div class="col-md-6">
							<input value="<?php echo $prescription_details_row['medication_time']; ?>" name="medication_times[]" type="text" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Times" />
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Symptoms *</label>
		<div class="col-md-12">
			<textarea name="symptoms" data-parsley-required="true" class="form-control" placeholder="Type symptoms" rows="5"><?php echo html_escape($row['symptoms']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Extra Note</label>
		<div class="col-md-12">
			<textarea name="extra_note" class="form-control" placeholder="Type extra notes" rows="5"><?php echo html_escape($row['extra_note']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Next Appointment</label>
		<div class="col-md-12">
			<input value="<?php if ($row['next_appointment']) echo html_escape(date('m/d/Y', $row['next_appointment'])); ?>" name="next_appointment" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
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

	$('#update_prescription_details').parsley();
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