<?php echo form_open_multipart('staff/create/' . $param2, array('id' => 'create_staff', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input autofocus name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the staff" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Email *</label>
	<div class="col-md-12">
		<input name="email" type="email" data-parsley-required="true" class="form-control" placeholder="Type email of the staff" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Password *</label>
	<div class="col-md-12">
		<input name="password" type="text" data-parsley-required="true" id="password-indicator-visible" placeholder="Type password of the staff" class="form-control m-b-5" />
		<div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Mobile Number *</label>
	<div class="col-md-12">
		<input name="mobile_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type mobile number of the staff" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Sex *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="sex_id">
			<option value="">Select sex of the staff</option>
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
		<input name="address_1" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 1 of the staff" />
		<br>
		<input name="address_2" type="text" data-parsley-required="true" class="form-control" placeholder="Type address line 2 of the staff" />
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

<script>
	"use strict";
	
	$('#create_staff').parsley();
	FormPlugins.init();
</script>