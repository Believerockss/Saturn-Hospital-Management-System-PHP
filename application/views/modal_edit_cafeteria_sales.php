<?php echo form_open('cafeteria_sales/edit/' . $param2, array('id' => 'update_cafeteria_sale', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Quantity</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($param3); ?>" class="form-control" placeholder="Type quantity" data-parsley-type="number" data-parsley-min="0" name="quantity">
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
	
	$('#update_cafeteria_sale').parsley();
	FormPlugins.init();
</script>