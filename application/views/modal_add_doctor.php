<?php 
	$departments = $this->security->xss_clean($this->db->get('department')->result_array()); 
	if (count($departments) == 0):
?>
<div class="note note-yellow">
	<ul style="margin-bottom: 0">
		<li>You have to add department first and then refresh: <a href="<?php echo base_url('departments'); ?>" target="_blank">Add Department</a></li>
	</ul>
</div>
<?php endif; ?>
<?php echo form_open_multipart('staff/create/' . $param2, array('id' => 'create_doctor', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Designation *</label>
	<div class="col-md-12">
		<input name="designation" type="text" data-parsley-required="true" class="form-control" placeholder="Type designation of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Degrees *</label>
	<div class="col-md-12">
		<input name="degrees" type="text" data-parsley-required="true" class="form-control" placeholder="Type degrees of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Email *</label>
	<div class="col-md-12">
		<input name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Password *</label>
	<div class="col-md-12">
		<input name="password" type="text" data-parsley-required="true" id="password-indicator-visible" placeholder="Type password of the doctor" class="form-control m-b-5" />
		<div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mobile Number *</label>
	<div class="col-md-12">
		<input name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Appointment Fee (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input name="appointment_fee" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" placeholder="Type appointment fee of the doctor" class="form-control" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Department *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="department_id">
			<option value="">Select department of the doctor</option>
			<?php foreach ($departments as $department) : ?>
			<option value="<?php echo html_escape($department['department_id']); ?>"><?php echo $department['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Profile Picture</label>
	<div class="col-md-12">
		<span class="btn btn-sm btn-yellow fileinput-button">
			<i class="fa fa-plus"></i>
			<span>Add image</span>
			<input name="image_link" type="file">
		</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Address *</label>
	<div class="col-md-12">
		<input name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the doctor" />
		<br>
		<input name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the doctor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Age *</label>
	<div class="col-md-12">
		<input name="age" id="age" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" onkeyup="changeBday()" placeholder="Type age of the doctor" class="form-control" />
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
			<option value="">Select sex of the doctor</option>
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
	
	$('#create_doctor').parsley();
	FormPlugins.init();
</script>