<?php echo form_open('feedback_and_ratings/ratings/create', array('id' => 'create_ratings', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
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
					?>
							<option value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $doctor['doctor_id']))->row()->user_id)); ?>"><?php echo $doctor['name']; ?></option>
						<?php
						endforeach;
					else :
						$staff =  $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
						foreach ($staff as $row) :
						?>
							<option value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $row['staff_id']))->row()->user_id)); ?>"><?php echo $row['name']; ?></option>
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
	<label class="col-md-12 col-form-label">Rating</label>
	<div class="col-md-12">
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="rating" id="1" value="1" />
			<label for="1">1</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="rating" id="2" value="2" />
			<label for="2">2</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="rating" id="3" value="3" />
			<label for="3">3</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="rating" id="4" value="4" />
			<label for="4">4</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="rating" id="5" value="5" checked />
			<label for="5">5</label>
		</div>
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
	
	$('#create_ratings').parsley();
	FormPlugins.init();
</script>