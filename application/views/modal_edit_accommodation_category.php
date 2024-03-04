<?php echo form_open('accommodation_categories/update/' . $param2, array('id' => 'update_accommodation_category', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$accommodation_categories = $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->result_array());
foreach ($accommodation_categories as $accommodation_category) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($accommodation_category['name']); ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the staff category" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Accommodation Type</label>
		<div class="col-md-12">
			<div class="radio radio-css radio-inline radio-inverse">
				<input <?php if ($accommodation_category['accommodation_type'] == 0) echo 'checked'; ?> type="radio" name="accommodation_type" id="single_room" value="0" checked />
				<label for="single_room">Single room</label>
			</div>
			<div class="radio radio-css radio-inline radio-inverse">
				<input <?php if ($accommodation_category['accommodation_type'] == 1) echo 'checked'; ?> type="radio" name="accommodation_type" id="is_bed" value="1" />
				<label for="is_bed">Is bed</label>
			</div>
			<div class="radio radio-css radio-inline radio-inverse">
				<input <?php if ($accommodation_category['accommodation_type'] == 2) echo 'checked'; ?> type="radio" name="accommodation_type" id="has_beds" value="2" />
				<label for="has_beds">Has beds</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Description *</label>
		<div class="col-md-12">
			<textarea name="description" data-parsley-required="true" class="form-control" placeholder="Type duties of the staff category" rows="5"><?php echo html_escape($accommodation_category['description']); ?></textarea>
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
	
	$('#update_accommodation_category').parsley();
	FormPlugins.init();
</script>