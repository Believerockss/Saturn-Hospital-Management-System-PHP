<?php echo form_open('reports/update/' . $param2, array('id' => 'update_report', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$report_categories_list = $this->security->xss_clean($this->db->get_where('report_details', array('report_id' => $param2))->result_array());
$report_cats = [];
foreach ($report_categories_list as $report_cat) {
	array_push($report_cats, $report_cat['report_category_id']);
}
$report_details = $this->db->get_where('report', array('report_id' => $param2))->result_array();
foreach ($report_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Report Category *</label>
		<div class="col-lg-12">
			<select id="report_cat" class="multiple-select2 form-control" multiple="multiple" data-parsley-required="true" name="report_category_id[]">
				<?php
				$report_categories = $this->security->xss_clean($this->db->get('report_category')->result_array());
				foreach ($report_categories as $report_category) :
				?>
					<option <?php if (in_array($report_category['report_category_id'], $report_cats)) echo 'selected'; ?> value="<?php echo html_escape($report_category['report_category_id']); ?>"><?php echo $report_category['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Description</label>
		<div class="col-md-12">
			<textarea name="description" class="form-control" placeholder="Type description of the report" rows="5"><?php echo html_escape($row['description']); ?></textarea>
		</div>
	</div>
	<?php if ($row['is_patient']) : ?>
		<div class="form-group">
			<label class="col-md-12 col-form-label">Patient *</label>
			<div class="col-md-12">
				<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="patient_id">
					<option value="">Select patient for the report</option>
					<?php
					$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
					foreach ($patients as $patient) :
					?>
						<option <?php if ($patient['patient_id'] == $row['patient_id']) echo 'selected'; ?> value="<?php echo html_escape($patient['patient_id']); ?>"><?php echo $patient['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	<?php else : ?>
		<div class="form-group">
			<label class="col-md-12 col-form-label">Customer Name *</label>
			<div class="col-md-12">
				<input value="<?php echo $row['customer_name']; ?>" class="form-control" data-parsley-required="true" placeholder="Type customer's name" type="text" name="customer_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12 col-form-label">Mobile Number *</label>
			<div class="col-md-12">
				<input value="<?php echo $row['customer_mobile']; ?>" class="form-control" data-parsley-required="true" placeholder="Type customer's mobile number" type="text" name="customer_mobile">
			</div>
		</div>
	<?php endif; ?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Delivery Date</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['delivery_date'])); ?>" name="delivery_date" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Discount (In percentage)</label>
		<div class="col-md-12">
			<input value="<?php echo $row['discount']; ?>" class="form-control" placeholder="Type discount on the whole sale" data-parsley-type="number" data-parsley-min="0" name="discount">
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

	$('#update_report').parsley();
	FormPlugins.init();

	$('.select2, .select2-search__field').css('width', '100%');

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