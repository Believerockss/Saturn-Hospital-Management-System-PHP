<?php echo form_open('prescriptions/create', array('id' => 'create_prescription', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
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
<div class="form-group">
	<label class="col-md-12 col-form-label">Disease *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="disease_id" data-parsley-required="true">
			<option value="">Select disease</option>
			<?php
			$diseases = $this->security->xss_clean($this->db->get('disease')->result_array());
			foreach ($diseases as $disease) :
			?>
				<option value="<?php echo $disease['disease_id']; ?>"><?php echo $disease['name']; ?></option>
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
	<div id="dynamic-field"></div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Symptoms *</label>
	<div class="col-md-12">
		<textarea name="symptoms" data-parsley-required="true" class="form-control" placeholder="Type symptoms" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Extra Note</label>
	<div class="col-md-12">
		<textarea name="extra_note" class="form-control" placeholder="Type extra notes" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Next Appointment</label>
	<div class="col-md-12">
		<input name="next_appointment" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
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

	$('#create_prescription').parsley();
	FormPlugins.init();
</script>

<script type="text/javascript">
	$(document).ready(function() {
		"use strict";

		var i = 0;
		$('#add-more').on('click', function() {
			i++;
			$('#dynamic-field').append(`
			<div id="row` + i + `">				
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