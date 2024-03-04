<?php echo form_open('inventory/create', array('id' => 'create_inventory', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Item Name *</label>
	<div class="col-md-12">
		<input name="item" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the item" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description *</label>
	<div class="col-md-12">
		<textarea data-parsley-required="true" name="description" class="form-control" placeholder="Type description" rows="5"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Qauntity *</label>
	<div class="col-md-12">
		<input name="quantity" class="form-control" placeholder="Type quantity of the item" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number" />
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
	
	$('#create_inventory').parsley();
	FormPlugins.init();
</script>