<?php echo form_open('staff/update/' . $param2 . '/' . $param3, array('id' => 'update_staff_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$staff_details = $this->db->get_where('staff', array('staff_id' => $param3))->result_array();
foreach ($staff_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the staff" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Email *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['email']); ?>" name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the staff" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mobile Number *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mobile_number']); ?>" name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the staff" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Staff Type *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_category_id">
				<option value="">Select type of the staff</option>
				<?php
				$staff_types = $this->security->xss_clean($this->db->get_where('staff_category', array('is_doctor' => 0))->result_array());
				foreach ($staff_types as $staff_type) :
				?>
					<option <?php if ($staff_type['staff_category_id'] == $row['staff_category_id']) echo 'selected'; ?> value="<?php echo html_escape($staff_type['staff_category_id']); ?>"><?php echo $staff_type['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Address *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[0]); ?>" name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the staff" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[1]); ?>" name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the staff" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Sex *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
				<option value="">Select sex of the staff</option>
				<option <?php if ($row['sex_id'] == 1) echo 'selected'; ?> value="1">Male</option>
				<option <?php if ($row['sex_id'] == 2) echo 'selected'; ?> value="2">Female</option>
				<option <?php if ($row['sex_id'] == 0) echo 'selected'; ?> value="0">Other</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Blood group *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="blood_inventory_id">
				<option value="">Select blood group</option>
				<?php
				$blood_groups = $this->security->xss_clean($this->db->get('blood_inventory')->result_array());
				foreach ($blood_groups as $blood_group) :
				?>
					<option <?php if ($blood_group['blood_inventory_id'] == $row['blood_inventory_id']) echo 'selected'; ?> value="<?php echo html_escape($blood_group['blood_inventory_id']); ?>"><?php echo $blood_group['blood_group_name']; ?></option>
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
	
	$('#update_staff_details').parsley();
	FormPlugins.init();
</script>