<?php echo form_open('reports/create/1', array('id' => 'create_report_patient', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Report Category *</label>
	<div class="col-md-12">
		<select id="report_cat" class="multiple-select2 form-control" multiple="multiple" data-parsley-required="true" name="report_category_id[]">
			<?php
			$report_categories = $this->security->xss_clean($this->db->get('report_category')->result_array());
			foreach ($report_categories as $report_category) :
			?>
				<option value="<?php echo html_escape($report_category['report_category_id']); ?>"><?php echo $report_category['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description</label>
	<div class="col-md-12">
		<textarea name="description" class="form-control" placeholder="Type description of the report" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="patient_id">
			<option value="">Select patient for the report</option>
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
	<label class="col-md-12 col-form-label">Delivery Date</label>
	<div class="col-md-12">
		<input name="delivery_date" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Discount (In percentage)</label>
	<div class="col-md-12">
		<input class="form-control" placeholder="Type discount on the whole sale" data-parsley-type="number" data-parsley-min="0" name="discount">
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
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Submit</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";

	$('#create_report_patient').parsley();
	FormPlugins.init();

	$('.select2, .select2-search__field').css('width', '100%');
	$('.select2, .select2-search').css('float', 'none');
	$('input.select2-search__field').attr('placeholder', 'Select one or multiple report categories');

	$("#report_cat").on('change', function() {
		var cats = [];
		$.each($("#report_cat option:selected"), function() {
			cats.push($(this).val());
		});

		if (cats.length == 0) {
			$('input.select2-search__field').attr('placeholder', 'Select one or multiple report categories');
		}
	});
</script>