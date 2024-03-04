<?php echo form_open('staff_categories/update/' . $param2, array('id' => 'update_staff_category', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$staff_categories = $this->db->get_where('staff_category', array('staff_category_id' => $param2))->result_array();
foreach ($staff_categories as $staff_category) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($staff_category['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the staff category" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Employment Type</label>
		<div class="col-md-12">
			<div class="radio radio-css radio-inline radio-inverse">
				<input <?php if ($staff_category['is_doctor'] == 0) echo 'checked'; ?> type="radio" name="is_doctor" id="not_doctor" value="0" />
				<label for="not_doctor">Not as a Doctor</label>
			</div>
			<div class="radio radio-css radio-inline radio-inverse">
				<input <?php if ($staff_category['is_doctor'] == 1) echo 'checked'; ?> type="radio" name="is_doctor" id="doctor" value="1" />
				<label for="doctor">As a Doctor</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Payroll Type *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="payment_type">
				<option value="">Select payroll type</option>
				<option <?php if ($staff_category['payment_type'] == 1) echo 'selected'; ?> value="1">Monthly</option>
				<option <?php if ($staff_category['payment_type'] == 2) echo 'selected'; ?> value="2">Shiftwise</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Pay Scale (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($staff_category['pay_scale']); ?>" name="pay_scale" data-parsley-type="number" data-parsley-min="0" class="form-control" placeholder="Type pay scale for the category" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Duties *</label>
		<div class="col-md-12">
			<textarea name="duties" data-parsley-required="true" class="form-control" placeholder="Type duties of the staff category" rows="5"><?php echo html_escape($staff_category['duties']); ?></textarea>
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
	
	$('#update_staff_category').parsley();
	FormPlugins.init();
</script>