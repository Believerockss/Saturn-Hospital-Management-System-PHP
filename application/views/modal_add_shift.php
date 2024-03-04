<?php echo form_open('shifts/create/' . $param2, array('id' => 'create_shift', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Shift Starts *</label>
	<div class="col-md-12">
		<div class="input-group bootstrap-timepicker">
			<input data-parsley-required="true" name="shift_starts" id="timepicker" type="text" class="form-control custom_timepicker" />
			<span class="input-group-addon"><i class="fa fa-clock"></i></span>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Shift Ends *</label>
	<div class="col-md-12">
		<div class="input-group bootstrap-timepicker">
			<input data-parsley-required="true" name="shift_ends" id="timepicker2" type="text" class="form-control custom_timepicker" />
			<span class="input-group-addon"><i class="fa fa-clock"></i></span>
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
	
	$('#create_shift').parsley();
	$('#timepicker2').timepicker();
	FormPlugins.init();
</script>