<?php echo form_open('transports/create/' . $param2, array('id' => 'create_transport', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Transport Number *</label>
	<div class="col-md-12">
		<input name="transport_number" type="text" data-parsley-required="true" class="form-control" placeholder="Type number of the transport" />
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
	
	$('#create_transport').parsley();
	FormPlugins.init();
</script>