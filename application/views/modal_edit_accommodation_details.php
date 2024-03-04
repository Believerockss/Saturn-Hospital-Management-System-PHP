<?php echo form_open('accommodations/update/' . $param2 . '/' . $param3, array('id' => 'update_accommodation', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$accommodation_details = $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $param3))->result_array());
foreach ($accommodation_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Room Number *</label>
		<div class="col-md-12">
			<input value="<?php echo $row['room_number']; ?>" name="room_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type number of the rpom" />
		</div>
	</div>
	<?php
	$accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->accommodation_type);
	if ($accommodation_type == 0) :
	?>
		<div class="form-group">
			<label class="col-md-12 col-form-label">Rent (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
			<div class="col-md-12">
				<input value="<?php echo $row['rent']; ?>" name="rent" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type rent of the bed" />
			</div>
		</div>
	<?php endif; ?>

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
	
	$('#update_accommodation').parsley();
	FormPlugins.init();
</script>