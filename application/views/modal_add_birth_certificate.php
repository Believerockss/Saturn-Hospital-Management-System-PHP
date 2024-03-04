<?php echo form_open('certificates/create/1', array('id' => 'create_birth_certificate', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the child" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Father's Name *</label>
	<div class="col-md-12">
		<input name="father_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type father's name of the child" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mother's Name *</label>
	<div class="col-md-12">
		<input name="mother_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type mother's name of the child" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Sex *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
			<option value="">Select sex of the child</option>
			<option value="1">Male</option>
			<option value="2">Female</option>
			<option value="0">Other</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Place *</label>
	<div class="col-md-12">
		<input name="place_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type born place address line 1 of the child" />
		<br>
		<input name="place_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type born place address line 2 of the child" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Age *</label>
	<div class="col-md-12">
		<input name="age" id="age" type="text" data-parsley-required="true" onkeyup="changeBday()" placeholder="Type age of the child" class="form-control" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Date of Birth *</label>
	<div class="col-md-12">
		<input name="dob" id="masked-input-date" type="text" data-parsley-required="true" onkeyup="changeAge()" class="form-control" placeholder="mm/dd/yyyy" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Email *</label>
	<div class="col-md-12">
		<input name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the parent" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mobile Number *</label>
	<div class="col-md-12">
		<input name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the parent" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Address *</label>
	<div class="col-md-12">
		<input name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the donor" />
		<br>
		<input name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the donor" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Reason *</label>
	<div class="col-md-12">
		<textarea name="reason" class="form-control" data-parsley-required="true" placeholder="Type reasons for the certificate" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Extra Note</label>
	<div class="col-md-12">
		<textarea name="extra_note" class="form-control" placeholder="Type extra note on the child" rows="5"></textarea>
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
	
	$('#create_birth_certificate').parsley();
	FormPlugins.init();
</script>