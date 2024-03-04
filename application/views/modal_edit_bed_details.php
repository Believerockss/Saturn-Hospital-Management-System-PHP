<?php echo form_open('accommodations/update/' . $param2 . '/' . $param3, array('id' => 'update_bed', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$bed_details = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $param3))->result_array());
foreach ($bed_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Bed Number *</label>
		<div class="col-md-12">
			<input value="<?php echo $row['bed_number']; ?>" name="bed_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type number of the bed" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Accommodation *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="accommodation_id" data-parsley-required="true">
				<option value="">Select accommodation</option>
				<?php
				$accommodation_categories = $this->security->xss_clean($this->db->get('accommodation_category')->result_array());
				foreach ($accommodation_categories as $accommodation_category) :
					if ($accommodation_category['accommodation_type'] == 2) :
				?>
						<optgroup label="<?php echo $accommodation_category['name']; ?>">
							<?php
							$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_category_id' => $accommodation_category['accommodation_category_id']))->result_array());
							foreach ($accommodations as $accommodation) :
							?>
								<option <?php if ($accommodation['accommodation_id'] == $row['accommodation_id']) {
											echo 'selected';
										} ?> value="<?php echo $accommodation['accommodation_id']; ?>"><?php echo $accommodation['room_number']; ?></option>
							<?php endforeach; ?>
						</optgroup>
				<?php
					endif;
				endforeach;
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Rent (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input value="<?php echo $row['rent']; ?>" name="rent" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type rent of the bed" />
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
	
	$('#update_bed').parsley();
	FormPlugins.init();
</script>