<?php echo form_open('feedback_and_ratings/feedback/update/' . $param2, array('id' => 'update_feedback', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Staff *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="user_id">
			<option value="">Select staff</option>
			<?php
			$staff_categories = $this->security->xss_clean($this->db->get('staff_category')->result_array());
			foreach ($staff_categories as $staff_category) :
			?>
				<optgroup label="<?php echo $staff_category['name']; ?>">
					<?php
					if ($staff_category['is_doctor']) :
						$doctors =  $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
						foreach ($doctors as $doctor) :
							$doctor_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $doctor['doctor_id']))->row()->user_id);
					?>
							<option <?php if ($this->security->xss_clean($this->db->get_where('feedback', array('feedback_id' => $param2))->row()->user_id == $doctor_user_id)) echo 'selected'; ?> value="<?php echo html_escape($doctor_user_id); ?>"><?php echo $doctor['name']; ?></option>
						<?php
						endforeach;
					else :
						$staff =  $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
						foreach ($staff as $row) :
							$staff_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $row['staff_id']))->row()->user_id);
						?>
							<option <?php if ($this->security->xss_clean($this->db->get_where('feedback', array('feedback_id' => $param2))->row()->user_id == $staff_user_id)) echo 'selected'; ?> value="<?php echo html_escape($staff_user_id); ?>"><?php echo $row['name']; ?></option>
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
	<label class="col-md-12 col-form-label">Feedback *</label>
	<div class="col-md-12">
		<textarea data-parsley-required="true" name="feedback" class="form-control" placeholder="Type feedback" rows="5"><?php echo $this->security->xss_clean($this->db->get_where('feedback', array('feedback_id' => $param2))->row()->feedback); ?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Update</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_feedback').parsley();
	FormPlugins.init();
</script>