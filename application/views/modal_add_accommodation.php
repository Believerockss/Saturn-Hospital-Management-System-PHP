<?php echo form_open('accommodations/create/' . $param2, array('id' => 'create_accommodation', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Room Number *</label>
	<div class="col-md-12">
		<input name="room_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type number of the room" />
	</div>
</div>
<?php
$accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->accommodation_type);
if ($accommodation_type == 0) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Rent (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input name="rent" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type rent of the bed" />
		</div>
	</div>
<?php endif; ?>

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
	
	$('#create_accommodation').parsley();
	FormPlugins.init();
</script>