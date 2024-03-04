<?php echo form_open('accommodation_categories/create', array('id' => 'create_accommodation_category', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the accommodation category" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Accommodation Type</label>
	<div class="col-md-12">
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="accommodation_type" id="single_room" value="0" checked />
			<label for="single_room">Single room</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="accommodation_type" id="is_bed" value="1" />
			<label for="is_bed">Is bed</label>
		</div>
		<div class="radio radio-css radio-inline radio-inverse">
			<input type="radio" name="accommodation_type" id="has_beds" value="2" />
			<label for="has_beds">Has beds</label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description *</label>
	<div class="col-md-12">
		<textarea maxlength="255" name="description" data-parsley-required="true" class="form-control" placeholder="Type description of the accommodation category" rows="5"></textarea>
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
	
	$('#create_accommodation_category').parsley();
	FormPlugins.init();
</script>