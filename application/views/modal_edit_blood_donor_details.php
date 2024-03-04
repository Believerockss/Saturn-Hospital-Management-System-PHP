<?php echo form_open('blood_donors/update/' . $param2, array('id' => 'update_blood_donor_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$blood_donor_details = $this->db->get_where('blood_donor', array('blood_donor_id' => $param2))->result_array();
foreach ($blood_donor_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the donor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Blood Group *</label>
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
		<label class="col-md-12 col-form-label">Mobile Number *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mobile_number']); ?>" name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the donor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Email</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['email']); ?>" name="email" type="email" class="form-control" placeholder="Type email of the donor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Address *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[0]); ?>" name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the donor" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[1]); ?>" name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the donor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Last Donated On</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['last_donated_on'])); ?>" name="last_donated_on" id="datepicker-autoClose" type="text" class="form-control" placeholder="Choose last donated date or keep empty for N/A" />
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
		<label class="col-md-12 col-form-label">Purpose *</label>
		<div class="col-md-12">
			<textarea name="purpose" data-parsley-required="true" class="form-control" placeholder="Type a brief description on the purpose for donation" rows="5"><?php echo html_escape($row['purpose']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Sex *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
				<option value="">Select sex of the donor</option>
				<option <?php if ($row['sex_id'] == 1) echo 'selected'; ?> value="1">Male</option>
				<option <?php if ($row['sex_id'] == 2) echo 'selected'; ?> value="2">Female</option>
				<option <?php if ($row['sex_id'] == 0) echo 'selected'; ?> value="0">Other</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Date of Birth</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['dob'])); ?>" name="dob" onkeyup="changeAge()" class="form-control" id="masked-input-date" placeholder="mm/dd/yyyy" type="text">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Age *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['age']); ?>" name="age" id="age" onkeyup="changeBday()" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type age of the donor" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Health Status *</label>
		<div class="col-md-12">
			<textarea name="health_status" data-parsley-required="true" class="form-control" placeholder="Type a little on the health status of the donor" rows="5"><?php echo html_escape($row['health_status']); ?></textarea>
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
	
	$('#update_blood_donor_details').parsley();
	FormPlugins.init();
</script>