<?php echo form_open('patients/update/' . $param2, array('id' => 'update_patient_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$patient_details = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
foreach ($patient_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">PID *</label>
		<div class="col-md-12">
			<input readonly value="<?php echo html_escape($row['pid']); ?>" name="pid" type="text" data-parsley-required="true" class="form-control" placeholder="Type ID of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Email *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['email']); ?>" name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mobile *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mobile_number']); ?>" name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Profession *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="profession_id">
				<option value="">Select profession of the donor</option>
				<?php
				$professions = $this->security->xss_clean($this->db->get('profession')->result_array());
				foreach ($professions as $profession) :
				?>
					<option <?php if ($profession['profession_id'] == $row['profession_id']) echo 'selected'; ?> value="<?php echo html_escape($profession['profession_id']); ?>"><?php echo $profession['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Father name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['father_name']); ?>" name="father_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type father name of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mother name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mother_name']); ?>" name="mother_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type mother name of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Address line 1 *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[0]); ?>" name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the patient" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[1]); ?>" name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Age *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['age']); ?>" name="age" id="age" data-parsley-required="true" data-parsley-type="number" data-parsley-min="0" onkeyup="changeBday()" placeholder="Type age of the patient" class="form-control" />
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
				<option value="">Select sex of the patient</option>
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
		<label class="col-md-12 col-form-label">Emergency Contact *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['emergency_contact']); ?>" name="emergency_contact" type="text" data-parsley-required="true" class="form-control" placeholder="Type emergency contact name of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Contact's number *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['emergency_contact_number']); ?>" name="emergency_contact_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type emergency contact's number of the patient" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Contact's relation *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['emergency_contact_relation']); ?>" name="emergency_contact_relation" type="text" data-parsley-required="true" class="form-control" placeholder="Type patient's relationship with the emergency contact" />
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
	
	$('#update_patient_details').parsley();
	FormPlugins.init();
</script>