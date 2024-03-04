<?php echo form_open('rosters/update/' . $param2, array('id' => 'update_roster_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$roster_details = $this->security->xss_clean($this->db->get_where('roster', array('roster_id' => $param2))->result_array());
foreach ($roster_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Duty Date *</label>
		<div class="col-md-12">
			<input name="duty_on" value="<?php echo html_escape(date('m/d/Y', $row['duty_on'])); ?>" id="masked-input-date" type="text" data-parsley-required="true" class="form-control" placeholder="mm/dd/yyyy" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Staff *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_id">
				<option value="">Select staff</option>
				<?php
				$is_doctor = $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $row['shift_id']))->row()->is_doctor);
				$shift_staff_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('payment_type' => 2))->result_array());
				foreach ($shift_staff_categories as $shift_staff_category) :
				?>
					<optgroup label="<?php echo $shift_staff_category['name']; ?>">
						<?php
						if ($shift_staff_category['is_doctor']) :
							$doctors = $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $shift_staff_category['staff_category_id']))->result_array());
							foreach ($doctors as $doctor) :
						?>
								<option <?php if (($is_doctor) && $doctor['doctor_id'] == $row['staff_id']) echo 'selected'; ?> value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
							<?php
							endforeach;
						else :
							$staff_details = $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $shift_staff_category['staff_category_id']))->result_array());
							foreach ($staff_details as $staff_detail) :
							?>
								<option <?php if (!($is_doctor) && $staff_detail['staff_id'] == $row['staff_id']) echo 'selected'; ?> value="<?php echo $staff_detail['staff_id']; ?>"><?php echo $staff_detail['name']; ?></option>
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
							<option <?php if ($shift['shift_id'] == $row['shift_id']) echo 'selected'; ?> value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_starts'] . ' - ' . $shift['shift_ends']; ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Extra note</label>
		<div class="col-md-12">
			<textarea name="extra_note" class="form-control" placeholder="Type an extra note" rows="5"><?php echo $row['extra_note']; ?></textarea>
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
	
	$('#update_roster_details').parsley();
	FormPlugins.init();
</script>