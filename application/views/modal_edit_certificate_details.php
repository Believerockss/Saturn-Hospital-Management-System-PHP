<?php echo form_open('certificates/update/' . $param2, array('id' => 'update_certificate', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$certificate_details = $this->db->get_where('certificate', array('certificate_id' => $param2))->result_array();
foreach ($certificate_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the deceased" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Father's Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['father_name']); ?>" name="father_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type father's name of the deceased" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mother's Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mother_name']); ?>" name="mother_name" type="text" data-parsley-required="true" class="form-control" placeholder="Type mother's name of the deceased" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Sex *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
				<option value="">Select sex of the deceased</option>
				<option <?php if ($row['sex_id'] == 1) echo 'selected'; ?> value="1">Male</option>
				<option <?php if ($row['sex_id'] == 2) echo 'selected'; ?> value="2">Female</option>
				<option <?php if ($row['sex_id'] == 0) echo 'selected'; ?> value="0">Other</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Place *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['place'])[0]); ?>" name="place_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type death place address line 1 of the child" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['place'])[1]); ?>" name="place_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type death place address line 2 of the child" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Age *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['age']); ?>" name="age" id="age" type="text" data-parsley-required="true" onkeyup="changeBday()" placeholder="Type age of the deceased" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Date of Birth *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(date('m/d/Y', $row['dob'])); ?>" name="dob" id="masked-input-date" type="text" data-parsley-required="true" onkeyup="changeAge()" class="form-control" placeholder="mm/dd/yyyy" />
		</div>
	</div>
	<?php if (!$row['certificate_type']) : ?>
		<div class="form-group">
			<label class="col-md-12 col-form-label">Date of Death *</label>
			<div class="col-md-12">
				<input value="<?php echo html_escape(date('m/d/Y', $row['dod'])); ?>" name="dod" data-parsley-required="true" type="text" class="form-control" id="datepicker-autoClose" placeholder="Choose date of death" />
			</div>
		</div>
	<?php endif; ?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Email *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['email']); ?>" name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the responsible person" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Mobile Number *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['mobile_number']); ?>" name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the responsible person" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Address *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[0]); ?>" name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the responsible person" />
			<br>
			<input value="<?php echo html_escape(explode('<br>', $row['address'])[1]); ?>" name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the responsible person" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Reason *</label>
		<div class="col-md-12">
			<textarea name="reason" class="form-control" data-parsley-required="true" placeholder="Type reasons for the certificate" rows="5"><?php echo html_escape($row['reason']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Extra Note</label>
		<div class="col-md-12">
			<textarea name="extra_note" class="form-control" placeholder="Type extra note on the deceased" rows="5"><?php echo html_escape($row['extra_note']); ?></textarea>
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
	
	$('#update_certificate').parsley();
	FormPlugins.init();
</script>