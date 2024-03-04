<?php echo form_open('invoice_requests/update_occurance/' . $param2, array('id' => 'update_invoice_request_occurance', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Occurance *</label>
	<div class="col-md-12">
		<input value="<?php echo $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $param2))->row()->quantity); ?>" name="quantity" class="form-control" placeholder="Type number of occurance for this item" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number" />
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
	
	$('#update_invoice_request_occurance').parsley();
	FormPlugins.init();
</script>