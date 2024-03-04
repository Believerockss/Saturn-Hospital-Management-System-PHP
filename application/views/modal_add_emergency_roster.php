<?php echo form_open('emergency_rosters/create', array('id' => 'create_emergency_roster', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Duty Date *</label>
	<div class="col-md-12">
		<input name="duty_on" id="masked-input-date" type="text" data-parsley-required="true" class="form-control" placeholder="mm/dd/yyyy" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Staff *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_id">
			<option value="">Select staff</option>
			<?php
			$shift_staff_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('payment_type' => 2))->result_array());
			foreach ($shift_staff_categories as $shift_staff_category) :
			?>
				<optgroup label="<?php echo $shift_staff_category['name']; ?>">
					<?php
					if ($shift_staff_category['is_doctor']) :
						$doctors = $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $shift_staff_category['staff_category_id']))->result_array());
						foreach ($doctors as $doctor) :
					?>
							<option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
						<?php
						endforeach;
					else :
						$staff_details = $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $shift_staff_category['staff_category_id']))->result_array());
						foreach ($staff_details as $staff_detail) :
						?>
							<option value="<?php echo $staff_detail['staff_id']; ?>"><?php echo $staff_detail['name']; ?></option>
					<?php
						endforeach;
					endif;
					?>
				</optgroup>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Shift *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="shift_id">
			<option value="">Select shift</option>
			<?php
			foreach ($shift_staff_categories as $shift_staff_category) :
			?>
				<optgroup label="<?php echo $shift_staff_category['name']; ?>">
					<?php
					$shifts = $this->security->xss_clean($this->db->get_where('shift', array('staff_category_id' => $shift_staff_category['staff_category_id']))->result_array());
					foreach ($shifts as $shift) :
					?>
						<option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_starts'] . ' - ' . $shift['shift_ends']; ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Extra note</label>
	<div class="col-md-12">
		<textarea name="extra_note" class="form-control" placeholder="Type an extra note" rows="5"></textarea>
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
	
	$('#create_emergency_roster').parsley();
	FormPlugins.init();
</script>