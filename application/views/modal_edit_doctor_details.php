<?php echo form_open('staff/update/' . $param2 . '/' . $param3, array('id' => 'update_doctor_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$doctor_details = $this->db->get_where('doctor', array('doctor_id' => $param3))->result_array();
foreach ($doctor_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Designation *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['designation']); ?>" name="designation" type="text" data-parsley-required="true" class="form-control" placeholder="Type designation of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Degrees *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['degrees']); ?>" name="degrees" type="text" data-parsley-required="true" class="form-control" placeholder="Type degrees of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Email *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['email']); ?>" name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mobile Number *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mobile_number']); ?>" name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Appointment Fee (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input name="appointment_fee" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" value="<?php echo html_escape($row['appointment_fee']); ?>" placeholder="Type appointment fee of the doctor" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Doctor Type *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_category_id">
				<option value="">Select type of the doctor</option>
				<?php
				$doctor_types = $this->security->xss_clean($this->db->get_where('staff_category', array('is_doctor' => 1))->result_array());
				foreach ($doctor_types as $doctor_type) :
				?>
					<option <?php if ($doctor_type['staff_category_id'] == $row['staff_category_id']) echo 'selected'; ?> value="<?php echo html_escape($doctor_type['staff_category_id']); ?>"><?php echo $doctor_type['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Department *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="department_id">
				<option value="">Select department of the doctor</option>
				<?php
				$departments = $this->security->xss_clean($this->db->get('department')->result_array());
				foreach ($departments as $department) :
				?>
					<option <?php if ($department['department_id'] == $row['department_id']) echo 'selected'; ?> value="<?php echo html_escape($department['department_id']); ?>"><?php echo $department['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Address *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[0]); ?>" name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the doctor" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[1]); ?>" name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the doctor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Age *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['age']); ?>" name="age" id="age" type="text" data-parsley-required="true" onkeyup="changeBday()" placeholder="Type age of the doctor" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Date of Birth *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['dob'])); ?>" name="dob" id="masked-input-date" type="text" data-parsley-required="true" onkeyup="changeAge()" class="form-control" placeholder="mm/dd/yyyy" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Sex *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
				<option value="">Select sex of the doctor</option>
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

<script type="text/javascript">
	"use strict";
	
	function changeAge() {
		var bday = document.getElementById("masked-input-date").value;
		var date_of_birth = new Date(bday).getFullYear();
		var today = new Date().getFullYear();
		var age = today - date_of_birth;

		document.getElementById("age").value = age;
	}

	function changeBday() {
		var age = document.getElementById("age").value;
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		var yyyy = today.getFullYear();
		var bday = yyyy - age;

		document.getElementById("masked-input-date").value = mm + "/" + dd + "/" + bday;
	}
</script>

<script>
	"use strict";
	
	$('#update_doctor_details').parsley();
	FormPlugins.init();
</script>