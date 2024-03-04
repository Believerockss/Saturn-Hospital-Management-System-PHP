<?php echo form_open('patients/create', array('id' => 'create_patient', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">PID *</label>
	<div class="col-md-12">
		<input name="pid" type="text" data-parsley-required="true" class="form-control" placeholder="Type ID of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Email *</label>
	<div class="col-md-12">
		<input name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Password *</label>
	<div class="col-md-12">
		<input name="password" type="text" data-parsley-required="true" id="password-indicator-visible" placeholder="Type password of the patient" class="form-control m-b-5" />
		<div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mobile *</label>
	<div class="col-md-12">
		<input name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Profession *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="profession_id">
			<option value="">Select profession of the patient</option>
			<?php
			$professions = $this->security->xss_clean($this->db->get('profession')->result_array());
			foreach ($professions as $profession) :
			?>
				<option value="<?php echo html_escape($profession['profession_id']); ?>"><?php echo $profession['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Father name *</label>
	<div class="col-md-12">
		<input name="father_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type father name of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mother name *</label>
	<div class="col-md-12">
		<input name="mother_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type mother name of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Address *</label>
	<div class="col-md-12">
		<input name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the patient" />
		<br>
		<input name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Age *</label>
	<div class="col-md-12">
		<input name="age" id="age" data-parsley-required="true" data-parsley-type="number" data-parsley-min="0" onkeyup="changeBday()" placeholder="Type age of the patient" class="form-control" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Date of Birth *</label>
	<div class="col-md-12">
		<input name="dob" id="masked-input-date" type="text" data-parsley-required="true" onkeyup="changeAge()" class="form-control" placeholder="mm/dd/yyyy" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Sex *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
			<option value="">Select sex of the patient</option>
			<option value="1">Male</option>
			<option value="2">Female</option>
			<option value="0">Other</option>
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
				<option value="<?php echo html_escape($blood_group['blood_inventory_id']); ?>"><?php echo $blood_group['blood_group_name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Emergency Contact *</label>
	<div class="col-md-12">
		<input name="emergency_contact" type="text" data-parsley-required="true" class="form-control" placeholder="Type emergency contact name of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Contact's number *</label>
	<div class="col-md-12">
		<input name="emergency_contact_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type emergency contact's number of the patient" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Contact's relation *</label>
	<div class="col-md-12">
		<input name="emergency_contact_relation" type="text" data-parsley-required="true" class="form-control" placeholder="Type patient's relationship with the emergency contact" />
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
	
	$('#create_patient').parsley();
	FormPlugins.init();
</script>